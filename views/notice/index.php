<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $events array */

$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-index">

    <h1><?= Html::encode($this->title) ?></h1>    

    <?php Pjax::begin(); ?>    

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'dateIn:datetime',
            [
                'attribute' => 'taskId',
                'value' => function(\app\models\Notice $model) {
                    $text = Html::tag('span', $model->task->name, ['class' => $model->actual ? '' : 'text-muted']);
                    return Html::a($text, ['task/view', 'id' => $model->task->id]);
                },
                'format' => 'raw'
            ],            
            [
                'attribute' => 'event',
                'value' => function(\app\models\Notice $model) use($events) {
                    return $events[$model->event];
                },
                'filter' => $events
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]);
    ?>

<?php Pjax::end(); ?>

</div>
