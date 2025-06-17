<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use app\models\User;
use app\services\AuthService;
use yii\filters\AccessControl;

class UserController extends \yii\web\Controller
{
    private $authService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'register'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            if ($this->authService->register($model)) {
                \Yii::$app->session->setFlash('success', 'Вы успешно зарегистрированы');
                return $this->redirect('/');
            } else {
                \Yii::$app->session->setFlash('error', 'Ошибки во время регистрации');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }


    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($this->authService->login($model)) {
                \Yii::$app->session->setFlash('success', 'Вы успешно вошли в систему');
                return $this->redirect('/');
            } else {
                \Yii::$app->session->setFlash('error', 'Неверный логин или пароль');
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}
