<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;
/**
 * Класс для заполнения пользователей
 * @version 1.0.0
 * @author Ilia Shumilov
 */
class User extends ActiveFixture {
    public $modelClass = \app\models\User::class;
}