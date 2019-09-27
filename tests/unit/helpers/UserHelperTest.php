<?php

namespace tests\unit\helpers;

use app\models\User;
use app\helpers\UserHelper;

class UserHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;
    /**
     * Тестирование формирования ФИО
     */
    public function testCorrectFio()
    {
        $user = new User();
        $user->name = 'Иван';
        $user->surname = 'Петров';
        $result = UserHelper::fio($user);
        $this->tester->assertEquals('И. Петров', $result);
    }
    
    /**
     * Тестирование формирования ФИО
     */
    public function testEmptyFio()
    {
        $user = new User();        
        $result = UserHelper::fio($user);
        $this->tester->assertEquals('', $result);
    }

}
