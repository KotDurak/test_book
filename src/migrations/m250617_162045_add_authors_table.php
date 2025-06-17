<?php

use yii\db\Migration;

class m250617_162045_add_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('authors', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string(),
            'surname'   => $this->string(),
            'patronymic'    => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('authors');
    }

}
