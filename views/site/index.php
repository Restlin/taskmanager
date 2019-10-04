<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Мой супер менеджер задач!</h1>       
    </div>
    <p><?= Html::a('Уведомления', ['notice/'], ['class' => 'btn btn-lg btn-success']); ?></p>
    <p><?= Html::a('Типы задач', ['task-type/'], ['class' => 'btn btn-lg btn-success']); ?></p>
    <p><?= Html::a('Проекты', ['project/'], ['class' => 'btn btn-lg btn-success']); ?></p>
    <p><?= Html::a('Пользователи', ['user/'], ['class' => 'btn btn-lg btn-success']); ?></p>
    <p><?= Html::a('Задачи', ['task/'], ['class' => 'btn btn-lg btn-success']); ?></p>
    
</div>
