<?php

namespace app\services;

use app\models\Book;
use yii\web\UploadedFile;

class BookService
{
    public function create(Book $book): bool
    {
        \Yii::$app->db->beginTransaction();
        $book->mainImage = UploadedFile::getInstance($book, 'mainImage');

        if (!empty($book->mainImage)) {
            $uploadPath = \Yii::getAlias(\Yii::$app->params['uploadsPath']);

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $filename = uniqid() . '.' . $book->mainImage->extension;
            if (!$book->mainImage->saveAs($uploadPath . $filename)) {
                return false;
            }

            $book->main_photo = $filename;
        }


        if (!$book->save(false)) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        if (!$this->attachAuthors($book)) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        \Yii::$app->db->transaction->commit();

        return true;
    }

    public function update(Book $book): bool
    {
        \Yii::$app->db->beginTransaction();
        $book->mainImage = UploadedFile::getInstance($book, 'mainImage');


        if (!$book->save()) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        \Yii::$app->db->createCommand()->delete('authors_books', ['book_id' => $book->id])->execute();

        if (!$this->attachAuthors($book)) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        \Yii::$app->db->transaction->commit();
        return true;
    }

    private function attachAuthors(Book $book): bool
    {
        $authors = array_map(static fn($id) => [
            $id, $book->id
        ], $book->authorIds);


        return (bool)\Yii::$app->db->createCommand()->batchInsert(
            'authors_books',
            ['author_id', 'book_id'],
            $authors
        )->execute();
    }
}