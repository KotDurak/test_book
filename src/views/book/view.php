<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Book;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить книгу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'year',
            'description:ntext',
            [
                'attribute' => 'authors',
                'format' => 'html',
                'value' => function(Book $model) {
                    $authors = [];
                    foreach ($model->authors as $author) {
                        $authors[] = Html::encode($author->fullName);
                    }
                    return implode(', ', $authors);
                },
            ],
            'isbn',
            [
                'attribute' => 'main_photo',
                'format'    => 'html',
                'value' => function(Book $model) {
                return Html::img($model->imageUrl, [
                    'style' => 'max-width: 200px; max-height: 200px',
                ]);
                },
            ]
        ],
    ]) ?>

</div>
