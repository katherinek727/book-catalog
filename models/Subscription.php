<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return 'subscription';
    }

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'updatedAtAttribute' => false, // subscription has no updated_at
            ],
        ];
    }

    public function rules()
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id'], 'integer'],
            [['author_id'], 'exist',
                'targetClass'     => Author::class,
                'targetAttribute' => ['author_id' => 'id'],
            ],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'trim'],
            [['phone'], 'match',
                'pattern' => '/^\+?[0-9]{7,15}$/',
                'message' => 'Phone must be 7–15 digits, optionally starting with +',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'author_id'  => 'Author',
            'phone'      => 'Phone Number',
            'created_at' => 'Subscribed At',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
