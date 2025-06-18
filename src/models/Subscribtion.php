<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscribtions".
 *
 * @property int $id
 * @property string $phone
 * @property int|null $author_id
 */
class Subscribtion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribtions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id'], 'default', 'value' => null],
            [['phone'], 'required'],
            [['author_id'], 'integer'],
            [['phone'], 'string', 'max' => 50],
            [['phone'], 'filter', 'filter' => function ($value) {
                return preg_replace('/\D+/', '', $value);
            }],
            [['phone'], 'uniqueSubscription'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'author_id' => 'Автор',
        ];
    }

    public function uniqueSubscription()
    {
        if (self::find()->where(['author_id' => $this->author_id, 'phone' => $this->phone])->exists()) {
            $this->addError('phone', 'Вы уже подписаны на данного автора');
        }
    }
}
