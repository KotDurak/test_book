<?php

namespace app\services;

use app\models\Book;
use app\services\notifier\BookNotifier;
use yii\web\UploadedFile;

class BookService
{
    public function __construct(private BookNotifier $bookNotifier) {}

    public function save(Book $book): bool
    {
        if (!$book->validate()) {
            return false;
        }


        \Yii::$app->db->beginTransaction();
        $this->processImages($book);

        if (!$book->save(false)) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        if (!$this->processAuthors($book)) {
            \Yii::$app->db->transaction->rollBack();
            return false;
        }

        \Yii::$app->db->transaction->commit();

        if ($book->processCreate) {
            $this->bookNotifier->runNotify($book);
        }

        return true;
    }

    public function delete(Book $book)
    {
       if(file_exists($book->uploadImagePath)) {
           unlink($book->uploadImagePath);
       }

        $book->delete();
    }

    private function processAuthors(Book $book): bool
    {

        if (!$book->processCreate) {
            \Yii::$app->db->createCommand()->delete('authors_books', ['book_id' => $book->id])->execute();
        }

        $authors = array_map(static fn($id) => [
            $id, $book->id
        ], $book->authorIds);


        return (bool)\Yii::$app->db->createCommand()->batchInsert(
            'authors_books',
            ['author_id', 'book_id'],
            $authors
        )->execute();
    }


    private function processImages(Book $book)
    {
        $book->mainImage = UploadedFile::getInstance($book, 'mainImage');

        if (!empty($book->mainImage)) {
            $uploadPath = \Yii::getAlias(\Yii::$app->params['uploadsPath']);

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            if (!$book->processCreate && file_exists($uploadPath . $book->main_photo)) {
                unlink($uploadPath . $book->main_photo);
            }

            $filename = uniqid() . '.' . $book->mainImage->extension;

            if (!$book->mainImage->saveAs($uploadPath . $filename)) {
                return false;
            }

            $book->main_photo = $filename;

            return true;
        }
    }
}