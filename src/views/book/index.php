<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'format' => 'html',
                'value' => function(Book $model) {
                    return Html::img($model->imageUrl, [
                            'style' => 'max-width: 100px',
                        ]);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return true;
                    },
                    'update' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest;
                    },
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest;
                    },
                ],
            ],
        ],
    ]); ?>


</div>
