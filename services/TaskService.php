<?php

namespace app\services;
use app\models\Task;
use app\repositories\TaskRepository;
use yii\web\ForbiddenHttpException;

/**
 * Сервис по работе с заданиями
 *
 * @author I.Shumilov
 */
class TaskService {
    /**
     * Взять задание в работу
     * @param Task $task задание
     * @return bool     
     */
    static public function takeToWork(Task $task): bool {
        $task->status = TaskRepository::STATUS_WORK;
        $task->dateStart = date('Y-m-d H:i:s');
        return $task->save();
    }
    /**
     * Отметить задачу готовой
     * @param Task $task задача
     * @return bool
     */
    static public function readyTask(Task $task): bool {
        $task->status = TaskRepository::STATUS_READY;        
        return $task->save();
    }
    /**
     * Отметить задачу выполненой
     * @param Task $task задача
     * @return bool
     */
    static public function doneTask(Task $task): bool {
        $task->status = TaskRepository::STATUS_DONE;
        $task->dateEnd = date('Y-m-d H:i:s');
        return $task->save();
    }
    /**
     * проверяет является ли пользователь исполнителем задачи
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function isExecutor(Task $task, \yii\web\User $user): bool {
        return $task->executorId == $user->id;
    }
    /**
     * проверяет является ли пользователь автором задачи
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function isAuthor(Task $task, \yii\web\User $user): bool {
        return $task->authorId == $user->id;
    }
    /**
     * Может ли пользователь взять задачу в работу
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function canTakeToWork(Task $task, \yii\web\User $user): bool {
        return self::isExecutor($task, $user) && $task->status == TaskRepository::STATUS_WAIT;
    }
    /**
     * Может ли пользователь отметить задачу готовой к проверке
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function canReady(Task $task, \yii\web\User $user): bool {
        return self::isExecutor($task, $user) && $task->status == TaskRepository::STATUS_WORK;
    }
    /**
     * Может ли пользователь отметить задачу выполненой
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function canDone(Task $task, \yii\web\User $user): bool {
        return self::isAuthor($task, $user) && $task->status == TaskRepository::STATUS_READY;
    }
    /**
     * Может ли пользователь изменять задачу
     * @param Task $task задача
     * @param \yii\web\User $user пользователь
     * @return bool
     */
    static public function canEdit(Task $task, \yii\web\User $user): bool {
        return self::isAuthor($task, $user) && $task->status == TaskRepository::STATUS_WAIT;
    }
}
