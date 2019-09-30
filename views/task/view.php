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
/* @var $canTakeToWork bool */
/* @var $canReady bool */
/* @var $canDone bool */
/* @var $canEdit bool */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1>Задача: <?= Html::encode($this->title) ?></h1>

    <p>
        <?php 
            if($canTakeToWork) {
              echo Html::a('Взять в работу', ['work', 'id' => $model->id], ['class' => 'btn btn-primary']);
            } elseif($canReady) {
              echo Html::a('Отметить готовой', ['ready', 'id' => $model->id], ['class' => 'btn btn-primary']);
            } elseif($canDone) {
              echo Html::a('Подтвердить выполнение', ['done', 'id' => $model->id], ['class' => 'btn btn-primary']);
            } elseif ($canEdit) {
              echo Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']),' ',
                   Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить задачу?',
                        'method' => 'post',
                    ]]);
            }
        ?>        
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
            'comment',
            'dateEnd:datetime',
            'dateLimit:date',
        ],
    ]) ?>

</div>
