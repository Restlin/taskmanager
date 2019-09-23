<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id Индетификатор
 * @property int $projectId идентификатор проекта
 * @property int $typeId идентификатор типа
 * @property int $priority приоритет
 * @property int $authorId идентификатор автора
 * @property int $executorId идентификатор исполнителя
 * @property int $status статус
 * @property string $name название
 * @property string $dateStart время начала
 * @property string $content содержимое
 * @property string $dateEnd дата конца
 * @property string $dateLimit контрольная дата
 *
 * @property User $author автор
 * @property User $executor исполнитель
 * @property Project $project проект
 * @property TaskType $type тип
 */
class Task extends \yii\db\ActiveRecord
{
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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId', 'typeId', 'priority', 'authorId', 'executorId', 'status', 'name', 'dateStart'], 'required'],
            [['projectId', 'typeId', 'priority', 'authorId', 'executorId', 'status'], 'integer'],
            [['dateStart', 'dateEnd', 'dateLimit'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 2000],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['authorId' => 'id']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executorId' => 'id']],
            [['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'id']],
            [['typeId'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['typeId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'projectId' => 'Проект',
            'typeId' => 'Тип',
            'priority' => 'Приоритет',
            'authorId' => 'Автор',
            'executorId' => 'Исполнитель',
            'status' => 'Статус',
            'name' => 'Название',
            'dateStart' => 'Начало',
            'content' => 'Содержимое',
            'dateEnd' => 'Конец',
            'dateLimit' => 'Срок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'authorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'projectId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TaskType::className(), ['id' => 'typeId']);
    }
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
