<?php

namespace app\services\notifier;

use app\models\Book;

interface BookNotifier
{
    public function runNotify(Book $book): void;
}