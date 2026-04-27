<?php

use yii\db\Migration;

class m240101_000004_create_subscription_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('subscription', [
            'id'         => $this->primaryKey(),
            'author_id'  => $this->integer()->notNull(),
            'phone'      => $this->string(20)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_subscription_author',
            'subscription', 'author_id',
            'author', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_subscription_author', 'subscription');
        $this->dropTable('subscription');
    }
}
