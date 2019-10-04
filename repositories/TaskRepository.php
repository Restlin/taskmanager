<?php
namespace app\repositories;

use app\models\Task;

/**
 * Репозиторий по работе с задачами
 *
 * @author I.Shumilov
 */
class TaskRepository {
    /**
     * Высокий приоритет
     */
    const PRIORITY_HIGH = 3;
    /**
     * Средний приоритет
     */
    const PRIORITY_NORMAL = 2;
    /**
     * Низкий приоритет
     */
    const PRIORITY_LOW = 1;
    /**
     * Статус в ожидании
     */
    const STATUS_WAIT = 0;
    /**
     * Статус в работе
     */
    const STATUS_WORK = 1;
    /**
     * Статус на проверке
     */
    const STATUS_READY = 2;
    /**
     * Статус выполнен
     */
    const STATUS_DONE = 3;
    /**
     * Статус отказа
     */
    const STATUS_REJECT = 4;
    /**
     * Установлен исполнитель задачи
     */
    const EVENT_SET_EXECUTOR = 'task_set_executor';
    /**
     * Задача взята в работу
     */
    const EVENT_START_WORK = 'task_start_work';
    /**
     * Задача готова к проверке
     */
    const EVENT_READY = 'task_ready';
    /**
     * Задача выполнена
     */
    const EVENT_DONE = 'task_done';
    /**
     * Получить перечень приорететов
     * @return array
     */
    public static function getPriorityList(): array {
        return [
            self::PRIORITY_HIGH => 'Высокий', 
            self::PRIORITY_NORMAL => 'Нормальный', 
            self::PRIORITY_LOW => 'Низкий'
        ];
    }
    /**
     * Получить перечень статусов
     * @return array
     */
    public static function getStatusList(): array {
        return [
            self::STATUS_WAIT => 'В ожидании',
            self::STATUS_WORK => 'В работе',
            self::STATUS_READY => 'На проверке',
            self::STATUS_DONE => 'Выполнен',
            self::STATUS_REJECT => 'Отказ',
        ];
    }
    /**
     * Получить перечень описаний событий
     * @return array
     */
    public static function getEventList(): array {
        return [
            self::EVENT_SET_EXECUTOR => 'Вам направлена новая задача',
            self::EVENT_START_WORK => 'Задачу взяли в работу',
            self::EVENT_READY => 'Задача готова к проверке',
            self::EVENT_DONE => 'Задача завершена',
        ];
    }
    /**
     * Найти задание по ИД
     * @param int $id ИД задания
     * @return Task
     */
    public static function findOne($id): Task {
        return Task::findOne($id);
    }
}
