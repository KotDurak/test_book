<?php

namespace app\services;

use app\models\Author;

class ReportService
{
    public function getTopAuthors(int $year, int $limit = 10): array
    {
        return Author::find()
            ->alias('a')
            ->select(['a.*', 'COUNT(b.id) as countBooks'])
            ->joinWith(['books as b'])
            ->where(['b.year' => $year])
            ->groupBy('a.id')
            ->orderBy(['countBooks' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}