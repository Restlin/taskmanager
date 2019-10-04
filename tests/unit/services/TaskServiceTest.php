<?php

namespace tests\unit\repositories;

use app\services\TaskService;
use app\repositories\TaskRepository;
use app\repositories\NoticeRepository;

/**
 * Класс тестирования сервиса по работе с задачами
 */
class TaskServiceTest extends \Codeception\Test\Unit {

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
            ],
            'projects' => [
                'class' => \app\tests\fixtures\Project::class,
                'dataFile' => codecept_data_dir() . 'projects.php'
            ],
            'tasks' => [
                'class' => \app\tests\fixtures\Task::class,
                'dataFile' => codecept_data_dir() . 'tasks.php'
            ],
        ]);
    }

    /**
     * Тест запуска задачи в работу
     */
    public function testStartWork() {
        $task = TaskRepository::findOne(1);
        TaskService::startWork($task);

        $this->tester->assertEquals(TaskRepository::STATUS_WORK, $task->status);
        $notice = NoticeRepository::findOneByTaskUser($task, $task->author);

        $this->tester->assertNotEmpty($notice);
        $this->tester->assertEquals(TaskRepository::EVENT_START_WORK, $notice->event);
    }

    /**
     * Тест установки признака просмотра задачи
     */
    public function testSetViewTask() {
        $task = TaskRepository::findOne(1);
        TaskService::setViewTask($task, $task->author);

        $notice = NoticeRepository::findOneByTaskUser($task, $task->author);
        $this->tester->assertNotEmpty($notice);
        $this->tester->assertEquals(0, $notice->actual);
    }

    /**
     * Тест установки признака готовности задачи
     */
    public function testReadyWork() {
        $task = TaskRepository::findOne(1);
        $comment = 'test';
        TaskService::readyTask($task, $comment);

        $this->tester->assertEquals(TaskRepository::STATUS_READY, $task->status);
        $this->tester->assertEquals($comment, $task->comment);

        $notice = NoticeRepository::findOneByTaskUser($task, $task->author);

        $this->tester->assertNotEmpty($notice);
        $this->tester->assertEquals(TaskRepository::EVENT_READY, $notice->event);
    }

    /**
     * Тест завершения задачи
     */
    public function testDoneTask() {
        $task = TaskRepository::findOne(1);

        TaskService::doneTask($task);

        $this->tester->assertEquals(TaskRepository::STATUS_DONE, $task->status);

        $notice = NoticeRepository::findOneByTaskUser($task, $task->executor);

        $this->tester->assertNotEmpty($notice);
        $this->tester->assertEquals(TaskRepository::EVENT_DONE, $notice->event);
    }
    /**
     * Проверка проверки исполнителя
     */
    public function testIsExecutor() {
        $task = TaskRepository::findOne(1);
        
        $result1 = TaskService::isExecutor($task, $task->executor);
        $this->tester->assertTrue($result1);
        
        $result2 = TaskService::isExecutor($task, $task->author);
        $this->tester->assertFalse($result2);
    }
    /**
     * Проверка проверки авторства
     */
    public function testIsAuthor() {
        $task = TaskRepository::findOne(1);
        
        $result1 = TaskService::isAuthor($task, $task->author);
        $this->tester->assertTrue($result1);
        
        $result2 = TaskService::isAuthor($task, $task->executor);
        $this->tester->assertFalse($result2);
    }
    /**
     * Проверка возможности взять задачу в работу
     */
    public function testCanStartWork() {
        $task = TaskRepository::findOne(1);
        
        $result1 = TaskService::canStartWork($task, $task->executor);
        $this->tester->assertTrue($result1);
        
        $result2 = TaskService::canStartWork($task, $task->author);
        $this->tester->assertFalse($result2);
    }
    /**
     * Проверка возможности отметить задачу готовой к проверке
     */
    public function testCanReady() {
        $task = TaskRepository::findOne(1);
        TaskService::startWork($task);
        
        $result1 = TaskService::canReady($task, $task->executor);
        $this->tester->assertTrue($result1);
        
        $result2 = TaskService::canReady($task, $task->author);
        $this->tester->assertFalse($result2);
    }
    /**
     * Проверка возможности выполнить задачу
     */
    public function testCanDone() {
        $task = TaskRepository::findOne(1);
        TaskService::readyTask($task, 'test');
        
        $result1 = TaskService::canDone($task, $task->author);
        $this->tester->assertTrue($result1);
        
        $result2 = TaskService::canDone($task, $task->executor);
        $this->tester->assertFalse($result2);
    }

}
