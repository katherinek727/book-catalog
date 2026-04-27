<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

class Book extends ActiveRecord
{
    /** @var UploadedFile */
    public $coverFile;

    public static function tableName()
    {
        return 'book';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'trim'],
            [['year'], 'integer', 'min' => 1000, 'max' => (int)date('Y')],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            [['isbn'], 'trim'],
            [['cover_image'], 'string', 'max' => 255],
            [['coverFile'], 'file',
                'skipOnEmpty' => true,
                'extensions'  => 'jpg, jpeg, png, webp',
                'maxSize'     => 1024 * 1024 * 2, // 2MB
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Title',
            'year'        => 'Year',
            'description' => 'Description',
            'isbn'        => 'ISBN',
            'cover_image' => 'Cover Image',
            'coverFile'   => 'Cover Image',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->coverFile instanceof UploadedFile) {
            $uploadDir = \Yii::getAlias('@webroot/uploads/covers/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Remove old cover on update
            if (!$insert && $this->cover_image) {
                $oldFile = $uploadDir . $this->cover_image;
                if (is_file($oldFile)) {
                    unlink($oldFile);
                }
            }

            $filename = uniqid('cover_', true) . '.' . $this->coverFile->extension;
            $this->coverFile->saveAs($uploadDir . $filename);
            $this->cover_image = $filename;
        }

        return true;
    }

    // Many-to-many: authors via book_author pivot
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }
}
