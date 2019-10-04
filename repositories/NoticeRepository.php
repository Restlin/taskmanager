<?php

namespace app\repositories;
use app\models\Notice;
use app\models\User;
use app\models\Task;
use app\repositories\TaskRepository;

/**
 * Репозиторий по работе с уведомлениями
 *
 * @author I.Shumilov
 */
class NoticeRepository {    
    /**
     * Найти уведомление по задаче и пользователю
     * @param Task $task задача
     * @param User $user пользователь
     * @return Notice
     */
    public static function findOneByTaskUser(Task $task, User $user): ?Notice {
        return Notice::findOne(['taskId' => $task->id, 'userId' => $user->id]);
    }
    /**
     * Создать уведомление пользователю о событии с 
     * @param \app\models\Task $task
     * @param \app\models\User $user
     * @param string $event событие
     * @return Notice
     */
    public static function add(\app\models\Task $task, \app\models\User $user, string $event): Notice {
        $notice = self::findOneByTaskUser($task, $user);
        if(!$notice) {
            $notice = new Notice();
            $notice->userId = $user->id;
            $notice->taskId = $task->id;
        }
        $notice->dateIn = date('Y-m-d H:i:s');
        $notice->event = $event;
        $notice->actual = 1;
        $notice->save();
        return $notice;
    }
    /**
     * Удаление уведомлений по задаче и событию
     * @param \app\models\Task $task задача
     * @param string $event событие
     * @return int
     */
    public static function deleteByTaskEvent(\app\models\Task $task, string $event): int {
        return Notice::deleteAll(['taskId' => $task->id, 'event' => $event]);
        
    }
    /**
     * Сброс показателя актуальности уведомлений по задаче и пользователю
     * @param \app\models\Task $task задача
     * @param \app\models\User $user пользователь
     * @return int
     */
    public static function setNotActualByTaskUser(\app\models\Task $task, \app\models\User $user): int {
        return Notice::updateAll(['actual' => 0], ['taskId' => $task->id, 'userId' => $user->id]);        
    }    
}
