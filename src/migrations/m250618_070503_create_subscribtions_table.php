<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribtions}}`.
 */
class m250618_070503_create_subscribtions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscribtions', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'author_id' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subscribtions');
    }
}
