<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * @var \app\models\forms\ReportForm $model
 * @var \app\models\Author[] $authors
 * @var \yii\web\View $this
*/

$this->title = "Топ авторов за {$model->year} г.";
$this->params['breadcrumbs'][] = $this->title;


$form = ActiveForm::begin([
    'method' => 'GET',
    'action' => Url::current([], true)
]);

echo $form->field($model, 'year')->textInput(['type' => 'number']);

echo Html::submitButton('Отчет');

ActiveForm::end();

?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Автор</th>
        <th scope="col">Количество книг</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($authors as $author): ?>
    <tr>
        <td><?php echo Html::encode($author->getFullName()) ?></td>
        <td><?php echo $author->countBooks ?></td>

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>