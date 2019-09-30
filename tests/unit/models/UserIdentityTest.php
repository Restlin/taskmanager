<?php

namespace tests\unit\models;

use app\models\UserIdentity;
use app\models\User;

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
    /**
     * Тестирование идентификации пользователя
     */
    public function testValidatePassword()
    {
        $model = new User();
        $model->name = 'Вася';
        $model->surname = 'Петров';
        $model->password = '12345';
        $model->email = 'test@test.ru';
        $model->save();        
        
        $identity = UserIdentity::findIdentity($model->id);
        
        $this->tester->assertEquals('Вася', $identity->name);
        $this->tester->assertEquals('Петров', $identity->surname);
        $this->tester->assertEquals('test@test.ru', $identity->email);        
        
        $this->tester->assertTrue($identity->validatePassword('12345'));
        
        $this->tester->assertFalse($identity->validatePassword('1234'));
    }

}
