<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Model;

class RegisterForm extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $phone;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [
                [
                    'name',
                    'email',
                    'phone',
                    'password',
                    'password_repeat',
                ],
                'required'
            ],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=> 'Пароли не совпадают'],
            ['email', 'unique', 'targetClass' => User::class],
            ['phone', 'unique', 'targetClass' => User::class],
        ];
    }


    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'password'  => 'Пароль',
            'password_repeat'   => 'Подтвердите пароль',
            'name'  => 'Имя',
            'surname'   => 'Фамилия',
            'patronymic'    => 'Отчество',
        ];
    }
}