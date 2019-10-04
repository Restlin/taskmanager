<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;
/**
 * Класс для заполнения проектов
 * @version 1.0.0
 * @author Ilia Shumilov
 */
class Project extends ActiveFixture {
    public $modelClass = \app\models\Project::class;
}