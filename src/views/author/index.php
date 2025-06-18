<?php

use app\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'surname',
            'patronymic',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {subscribe}',
                'buttons' => [
                    'subscribe' => function ($url, $model, $key) {
                        return Html::a('Подписаться', ['subscribe/create', 'authorId' => $model->id], [
                            'class' => 'btn btn-primary btn-sm',
                            'title' => 'Подписаться'
                        ]);
                    },
                ],
                'visible' => true,
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
                    'subscribe' => function ($model, $key, $index) {
                        return Yii::$app->user->isGuest;
                    },
                ],
            ],
        ],
    ]); ?>


</div>
