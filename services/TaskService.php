<?php

namespace app\services;
use app\models\Task;
use app\models\User;
use app\repositories\TaskRepository;
use app\repositories\NoticeRepository;

/**
 * Сервис по работе с заданиями
 *
 * @author I.Shumilov
 */
class TaskService {    
    /**
     * Обработка после сохранения задачи
     * @param Task $task
     */
    static public function afterTaskSave(Task $task) {
        NoticeRepository::deleteByTaskEvent($task, TaskRepository::EVENT_SET_EXECUTOR); //удаление уведомлений по старому исполнителю если был
        NoticeRepository::add($task, $task->executor, TaskRepository::EVENT_SET_EXECUTOR); //уведомление новому
    }
    /**
     * Обработка просмотра пользователем задачи
     * @param Task $task задача
     * @param \app\models\User $user пользователь
     */
    static public function setViewTask(Task $task, \app\models\User $user) {
        NoticeRepository::setNotActualByTaskUser($task, $user);
    }
    /**
     * Взять задание в работу
     * @param Task $task задание
     * @return bool     
     */
    static public function startWork(Task $task): bool {
        $task->status = TaskRepository::STATUS_WORK;
        $task->dateStart = date('Y-m-d H:i:s');
        $result = $task->save();
        if($result) {
            NoticeRepository::deleteByTaskEvent($task, TaskRepository::EVENT_SET_EXECUTOR);
            NoticeRepository::add($task, $task->author, TaskRepository::EVENT_START_WORK);
        }
        return $result;
    }
    /**
     * Отметить задачу готовой
     * @param Task $task задача
     * @param string $comment комментарий исполнителя
     * @return bool
     */
    static public function readyTask(Task $task, ?string $comment): bool {
        $task->status = TaskRepository::STATUS_READY;
        $task->comment = $comment;
        $result = $task->save();
        if($result) {
            NoticeRepository::deleteByTaskEvent($task, TaskRepository::EVENT_START_WORK);
            NoticeRepository::add($task, $task->author, TaskRepository::EVENT_READY);
        }
        return $result;
    }
    /**
     * Отметить задачу выполненой
     * @param Task $task задача
     * @return bool
     */
    static public function doneTask(Task $task): bool {
        $task->status = TaskRepository::STATUS_DONE;
        $task->dateEnd = date('Y-m-d H:i:s');
        $result = $task->save();
        if($result) {
            NoticeRepository::deleteByTaskEvent($task, TaskRepository::EVENT_READY);
            NoticeRepository::add($task, $task->executor, TaskRepository::EVENT_DONE);
        }
        return $result;
    }
    /**
     * проверяет является ли пользователь исполнителем задачи
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function isExecutor(Task $task, User $user): bool {
        return $task->executorId == $user->id;
    }
    /**
     * проверяет является ли пользователь автором задачи
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function isAuthor(Task $task, User $user): bool {
        return $task->authorId == $user->id;
    }
    /**
     * Может ли пользователь взять задачу в работу
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function canStartWork(Task $task, User $user): bool {
        return self::isExecutor($task, $user) && $task->status == TaskRepository::STATUS_WAIT;
    }
    /**
     * Может ли пользователь отметить задачу готовой к проверке
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function canReady(Task $task, User $user): bool {
        return self::isExecutor($task, $user) && $task->status == TaskRepository::STATUS_WORK;
    }
    /**
     * Может ли пользователь отметить задачу выполненой
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function canDone(Task $task, User $user): bool {
        return self::isAuthor($task, $user) && $task->status == TaskRepository::STATUS_READY;
    }
    /**
     * Может ли пользователь изменять задачу
     * @param Task $task задача
     * @param User $user пользователь
     * @return bool
     */
    static public function canEdit(Task $task, User $user): bool {
        return self::isAuthor($task, $user) && $task->status == TaskRepository::STATUS_WAIT;
    }
}
