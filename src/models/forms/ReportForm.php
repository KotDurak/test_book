<?php

namespace app\models\forms;

use yii\base\Model;

class ReportForm extends Model
{
    public $year;

    public function rules()
    {
        return [
            ['year', 'integer'],
            ['yest', 'default', 'value' => date('Y')]
        ];
    }
}