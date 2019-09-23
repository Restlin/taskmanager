<?php
namespace app\repositories;

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
}
