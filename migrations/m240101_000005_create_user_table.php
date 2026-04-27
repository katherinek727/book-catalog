<?php

use yii\db\Migration;

class m240101_000005_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id'            => $this->primaryKey(),
            'username'      => $this->string(50)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key'      => $this->string(32)->notNull(),
            'access_token'  => $this->string(40)->null(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
