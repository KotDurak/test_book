<?php

use yii\db\Migration;

class m250617_103906_add_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull(),
            'password'      => $this->string(),
            'phone' => $this->string(15),
            'email' => $this->string(),
            'auth_key'  => $this->string(),
        ]);

        $this->createIndex('users_phone_index', 'users', 'phone', true);
        $this->createIndex('users_email_index', 'users', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('users_phone_index', 'users');
        $this->dropIndex('users_email_index', 'users');

        $this->dropTable('users');
    }
}
