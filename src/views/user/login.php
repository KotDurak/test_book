<?php

/**
 * @var \app\models\forms\LoginForm $model;
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Войти';

?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'email')->textInput() ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'remember_me')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>