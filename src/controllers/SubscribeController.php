<?php

namespace app\controllers;

use app\models\Subscribtion;
use app\services\AuthorsService;
use yii\filters\AccessControl;
use yii\web\Controller;

class SubscribeController extends Controller
{
    private AuthorsService $authorsService;

    public function __construct($id, $module, AuthorsService $authorsService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authorsService = $authorsService;
    }

    public function behaviors()
    {
       return [
           'access' => [
               'class' => AccessControl::class,
               'rules' => [
                   [
                       'actions' => ['create'],
                       'allow' => true,
                       'roles' => ['?']
                   ],
               ]
           ]
       ];
    }

    public function actionCreate(int $authorId)
    {
        $model = new Subscribtion([
            'author_id' => $authorId,
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Вы успешно подписались');
            return $this->redirect('/author');
        }


        return $this->render('create', [
            'model'      => $model,
            'authors'     => $this->authorsService->getAuthors(),
        ]);
    }
}