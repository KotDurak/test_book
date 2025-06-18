<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var \app\models\Subscribtion $model
 * @var array $authors
*/
?>

<div id="subscribe_form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'author_id')->dropDownList($authors) ?>

    <?php echo $form->field($model, 'phone')->textInput([
        'placeholder' => '+7 (___) ___-__-__',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


