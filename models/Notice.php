<?php

namespace app\models;

use Yii;
use app\repositories\TaskRepository;

/**
 * Модель уведомлений по таблице notice
 *
 * @property int $id ИД
 * @property int $taskId ИД задачи
 * @property int $userId ИД пользователя
 * @property string $dateIn Время получения
 * @property string $event Событие уведомления
 * @property int $actual Время получения
 *
 * @property Task $task задача
 * @property User $user пользователь
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taskId', 'userId', 'dateIn', 'event'], 'required'],
            [['taskId', 'userId', 'actual'], 'integer'],
            [['dateIn'], 'safe'],
            [['event'], 'string', 'max' => 255],
            [['event'], 'in', 'range' => array_keys(TaskRepository::getEventList())],
            [['taskId'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['taskId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'taskId' => 'Задача',
            'userId' => 'Пользователь',
            'dateIn' => 'Время получения',
            'event' => 'Уведомление',
            'actual' => 'Время получения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'taskId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
