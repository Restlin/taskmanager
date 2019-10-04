<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;
/**
 * Класс для заполнения типов задач
 * @version 1.0.0
 * @author Ilia Shumilov
 */
class TaskType extends ActiveFixture {
    public $modelClass = \app\models\TaskType::class;
}