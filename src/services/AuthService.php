<?php

namespace app\services;

use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use app\models\User;
use yii\web\NotFoundHttpException;

class AuthService
{
    const LOGIN_DURATION = 30 * 24 * 60 * 60;
    public function register(RegisterForm $model): bool
    {
        $user = new User();
        $user->name = $model->name;
        $user->phone = $model->phone;
        $user->email = $model->email;
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->password = \Yii::$app->security->generatePasswordHash($model->password);

        return $user->save();
    }

    public function login(LoginForm $model)
    {
        $user = User::findOne(['email' => $model->email]);

        if (empty($user)) {
            return false;
        }

        if (!\Yii::$app->security->validatePassword($model->password, $user->password)) {
            return false;
        }

        return \Yii::$app->user->login(
            $user,
            $model->remember_me ? self::LOGIN_DURATION : 0
        );
    }
}