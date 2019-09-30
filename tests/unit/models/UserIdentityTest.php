<?php

namespace tests\unit\models;

use app\models\UserIdentity;

class UserIdentityTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    /**
     * Подготовка данных
     */
    protected function _before() {
        $this->tester->haveFixtures([
            'users' => [
                'class' => \app\tests\fixtures\User::class,
                'dataFile' => codecept_data_dir() . 'users.php'
            ]
        ]);
    }
    /**
     * Тестирование идентификации пользователя
     */
    public function testFindById()
    {
        $identity = UserIdentity::findIdentity(1);
        $this->tester->assertEquals('Иван', $identity->name);
        $this->tester->assertEquals('12345', $identity->password);
        $this->tester->assertEquals('ip@ya.ru', $identity->email);
    }    

}
