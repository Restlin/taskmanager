<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\UserHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $projects array */
/* @var $types array */
/* @var $users array */
/* @var $priorities array */
/* @var $statuses array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1>Задача: <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить задачу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'projectId',
                'value' => $model->project->name,
            ],
            [
                'attribute' => 'typeId',
                'value' => $model->type->name,
            ],
            [
                'attribute' => 'priority',
                'value' => $priorities[$model->priority],
            ],            
            [
                'attribute' => 'authorId',
                'value' => UserHelper::fio($model->author),
            ],
            [
                'attribute' => 'executorId',
                'value' => UserHelper::fio($model->executor),
            ],
            [
                'attribute' => 'status',
                'value' => $statuses[$model->status],
            ],
            'name',
            'dateStart:datetime',
            'content',
            'dateEnd:datetime',
            'dateLimit:date',
        ],
    ]) ?>

</div>
