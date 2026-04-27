<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'author';
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
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
            [['full_name'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'full_name'  => 'Full Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // Many-to-many: books via book_author pivot
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id']);
    }

    // One-to-many: subscriptions
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::class, ['author_id' => 'id']);
    }
}
