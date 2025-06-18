<?php

namespace app\services\notifier;

use app\models\Book;

class RabbitMQNotifier implements BookNotifier
{

    public function runNotify(Book $book): void
    {
        //TODO для отправки в очередь
    }
}