<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "taskType".
 *
 * @property int $id идентификатор
 * @property string $name наименование
 *
 * @property Task[] $tasks
 */
class TaskType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taskType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {        
        return $this->hasMany(Task::className(), ['typeId' => 'id']);
    }    
}
