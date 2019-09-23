<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\helpers\UserHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $projects array */
/* @var $types array */
/* @var $users array */
/* @var $priorities array */
/* @var $statuses array */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'projectId',
                'value' => function(app\models\Task $model) {
                    return $model->project->name;
                },
                'filter' => $projects
            ],
            [
                'attribute' => 'typeId',
                'value' => function(app\models\Task $model) {
                    return $model->type->name;
                },
                'filter' => $types
            ],
            [
                'attribute' => 'priority',
                'value' => function(app\models\Task $model)  use($priorities) {
                    return $priorities[$model->priority];
                },
                'filter' => $priorities
            ],
            'name',
            [
                'attribute' => 'authorId',
                'value' => function(app\models\Task $model) {
                    return UserHelper::fio($model->author);
                },
                'filter' => $users,
            ],
            [
                'attribute' => 'executorId',
                'value' => function(app\models\Task $model) {
                    return UserHelper::fio($model->executor);
                },
                'filter' => $users,
            ],
            [
                'attribute' => 'status',
                'value' => function(app\models\Task $model) use ($statuses) {
                    return $statuses[$model->status];
                },
                'filter' => $statuses
            ],
            'dateStart:datetime',
            'dateEnd',
            [
                'attribute' => 'dateLimit',
                'format' => 'date',
            ],

            [
                'header' => 'Действия',
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
