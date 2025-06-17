<?php

namespace app\commands;

use app\services\seed\AuthorSeedService;
use yii\console\Controller;

class AuthorSeedController extends Controller
{
    private AuthorSeedService $seedService;

    public function __construct($id, $module, AuthorSeedService $seedService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->seedService = $seedService;
    }
    public function actionSeed(int $count = 200)
    {
        $this->seedService->seed($count);

        echo "Создано {$count} пользоватей \n";
    }
}