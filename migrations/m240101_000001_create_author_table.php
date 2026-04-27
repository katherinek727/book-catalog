<?php

use yii\db\Migration;

class m240101_000001_create_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('author', [
            'id'         => $this->primaryKey(),
            'full_name'  => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('author');
    }
}
