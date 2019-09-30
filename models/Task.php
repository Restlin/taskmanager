<?php

namespace app\models;

use app\repositories\TaskRepository;
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
 * @property string $comment комментарий
 *
 * @property User $author автор
 * @property User $executor исполнитель
 * @property Project $project проект
 * @property TaskType $type тип
 */
class Task extends \yii\db\ActiveRecord
{    
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
            [['comment'], 'string', 'max' => 1000],
            [['content'], 'string', 'max' => 2000],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['authorId' => 'id']],
            [['executorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executorId' => 'id']],
            [['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'id']],
            [['typeId'], 'exist', 'skipOnError' => true, 'targetClass' => TaskType::className(), 'targetAttribute' => ['typeId' => 'id']],
            [['priority'], 'in', 'range' => array_keys(TaskRepository::getPriorityList())],
            [['status'], 'in', 'range' => array_keys(TaskRepository::getStatusList())],
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
            'comment' => 'Комментарий исполнителя',
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
}
