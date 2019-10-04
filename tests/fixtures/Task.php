<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;
/**
 * Класс для заполнения задач
 * @version 1.0.0
 * @author Ilia Shumilov
 */
class Task extends ActiveFixture {
    public $modelClass = \app\models\Task::class;
}