<?php

use yii\db\Migration;

class m250617_164450_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('authors_books', [
            'id'    => $this->primaryKey(),
            'author_id' => $this->integer()->unsigned(),
            'book_id'   => $this->integer()->unsigned(),
        ]);

        $this->createIndex(
            'index_authors_books_author_book',
            'authors_books',
            ['author_id', 'book_id']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('index_authors_books_author_book', 'authors_books');
        $this->dropTable('authors_books');
    }
}
