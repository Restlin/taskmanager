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
            [
                'attribute' => 'id',
                'label' => 'Проект/№',
                'value' => function(app\models\Task $model) {
                    return $model->project->name."\n№ ".$model->id;                    
                },
                'filter' => Html::activeDropDownList($searchModel, 'projectId', $projects, ['prompt' => 'Проект', 'class' => 'form-control']).
                            Html::activeTextInput($searchModel, 'id', ['placeholder' => 'Код задачи', 'class' => 'form-control']),
                'format' => 'ntext'
            ],
            [
                'attribute' => 'typeId',
                'label' => 'Тип/Приоритет',
                'value' => function(app\models\Task $model) use($priorities) {
                    return $priorities[$model->priority].":\n".$model->type->name;
                },
                'filter' => Html::activeDropDownList($searchModel, 'typeId', $types, ['prompt' => 'Тип задачи', 'class' => 'form-control']).
                            Html::activeDropDownList($searchModel, 'priority', $priorities, ['prompt' => 'Приоритет', 'class' => 'form-control']),
                'format' => 'ntext'
            ],
            [
                'attribute' => 'name',
                'label' => 'Название/Автор',
                'value' => function(app\models\Task $model) {
                    return Html::a($model->name, ['view', 'id' => $model->id])."<br>(".UserHelper::fio($model->author).")";
                },
                'format' => 'raw',
                'filter' => Html::activeTextInput($searchModel, 'name', ['placeholder' => 'Название', 'class' => 'form-control']).
                        Html::activeDropDownList($searchModel, 'authorId', $users, ['prompt' => 'Автор', 'class' => 'form-control']),
            ],
            [
                'attribute' => 'executorId',
                'label' => 'Статус/Исполнитель',
                'value' => function(app\models\Task $model) use ($statuses) {
                    return $statuses[$model->status]."\n(".UserHelper::fio($model->executor).")";
                },
                'format' => 'ntext',
                'filter' => Html::activeDropDownList($searchModel, 'status', $statuses, ['prompt' => 'Статус', 'class' => 'form-control']).
                            Html::activeDropDownList($searchModel, 'executorId', $users, ['prompt' => 'Исполнитель', 'class' => 'form-control']),
            ],
            'dateStart:datetime',
            'dateEnd:datetime',
            [
                'attribute' => 'dateLimit',
                'format' => 'date',
                'contentOptions' => function(app\models\Task $model) {
                    $now = new DateTime();
                    $dateLimit = new DateTime($model->dateLimit);
                    $isOutDate = $now > $dateLimit;
                    return $isOutDate ? ['class' => 'text-danger', 'title' => 'Задание просрочено!'] : [];
                }
            ],            
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
