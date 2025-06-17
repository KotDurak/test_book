<?php

namespace app\services\seed;

use app\models\Author;
use app\models\User;

class AuthorSeedService
{
    public function seed(int $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $author = new Author();
            $author->name = 'Автор_' . $i;
            $author->surname = 'Фамилия_' . $i;
            $author->patronymic = 'Отчество_' . $i;
            $author->save();

        }
    }
}