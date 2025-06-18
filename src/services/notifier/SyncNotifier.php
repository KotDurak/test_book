<?php

namespace app\services\notifier;

use app\componets\SmsClient;
use app\models\Author;
use app\models\Book;
use app\models\Subscribtion;
use app\services\AuthorsService;

class SyncNotifier implements BookNotifier
{
    private SmsClient $smsClient;

    public function __construct(private AuthorsService $authorsService)
    {
        $this->smsClient = \Yii::$app->get('smsClient');
    }
    public function runNotify(Book $book): void
    {
        $phones = $this->getSubscriptionsPhones($book->authorIds);
        $authors = $this->authorsService->getByIds($book->authorIds);

        $text = "Вышла книга '{$book->name}' за авторством: ";
        $text .= implode(', ', array_map(static fn(Author $author) => $author->fullName, $authors));
        $this->smsClient->sendBatch($phones, $text);
    }

    private function getSubscriptionsPhones(array $authorIds): array
    {
        return Subscribtion::find()->select('phone')
            ->where(['author_id' => $authorIds])
            ->asArray()
            ->distinct()
            ->column();
    }

}