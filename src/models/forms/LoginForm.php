<?php

namespace app\models\forms;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $remember_me = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['remember_me', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password'  => 'Пароль',
            'remember_me'   => 'Запомнить',
        ];
    }
}