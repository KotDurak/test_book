<?php

/**
 * @var \app\models\forms\RegisterForm $model
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';

?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'name')->textInput() ?>
<?php echo $form->field($model, 'phone')->textInput() ?>
<?php echo $form->field($model, 'email')->textInput() ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>