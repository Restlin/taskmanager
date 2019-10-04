<?php

namespace tests\unit\repositories;

use app\repositories\NoticeRepository;
use app\repositories\TaskRepository;

/**
 * Класс тестирования репозитория по работе с уведомлениями
 */
class NoticeRepositoryTest extends \Codeception\Test\Unit {

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
     * Тестируем создание плохого уведомления
     */
    public function testAddBadEvent() {
        $task = TaskRepository::findOne(1);
        $notice = NoticeRepository::add($task, $task->executor, 'bad');

        $this->tester->assertTrue($notice->isNewRecord);
        $this->tester->assertTrue($notice->hasErrors('event'));
        $this->tester->assertEmpty($notice->id);
    }

    /**
     * Тестирование создания уведомления
     */
    public function testAdd() {
        $task = TaskRepository::findOne(1);
        $notice = NoticeRepository::add($task, $task->executor, TaskRepository::EVENT_SET_EXECUTOR);

        $this->tester->assertNotEmpty($notice->id);
        $this->tester->assertFalse($notice->hasErrors());
        $this->tester->assertEquals($task->executorId, $notice->userId);
        $this->tester->assertEquals($task->id, $notice->taskId);
        $this->tester->assertEquals(TaskRepository::EVENT_SET_EXECUTOR, $notice->event);
        $this->tester->assertEquals(1, $notice->actual);
    }

    /**
     * Тестирование установки неактуальности
     */
    public function testSetNotActual() {
        $task = TaskRepository::findOne(1);
        NoticeRepository::setNotActualByTaskUser($task, $task->executor);
        $notices = $task->executor->notices;
        $notice = $notices[0];
        $this->tester->assertEquals($task->id, $notice->taskId);
        $this->tester->assertEquals($task->executorId, $notice->userId);
        $this->tester->assertEquals(0, $notice->actual);
    }
    /**
     * Тестирование удаления уведомления по задаче и типу события
     */
    public function testDeleteByTaskEvent() {
        $task = TaskRepository::findOne(1);        
        NoticeRepository::deleteByTaskEvent($task, TaskRepository::EVENT_SET_EXECUTOR);
        $this->tester->assertEmpty($task->executor->notices);        
    }
}
