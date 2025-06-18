<?php

namespace app\services;

use app\models\Author;
use yii\helpers\ArrayHelper;

class AuthorsService
{
    public function getAuthors(): array
    {
        $authors = Author::find()->asArray()->all();

        return ArrayHelper::map($authors, 'id', static function($author) {
            return implode(', ', [$author['surname'], $author['name'], $author['patronymic']]);
        });
    }

    /**
     * @param array $ids
     * @return Author[]
     */
    public function getByIds(array $ids): array
    {
        return Author::find()->where(['id' => $ids])->all();
    }
}