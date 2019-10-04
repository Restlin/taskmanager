<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id идентификатор
 * @property string $email адрес email
 * @property string $password хеш пароля
 * @property string $surname фамилия
 * @property string $name имя
 * @property string $patronymic отчество
 *
 * @property Task[] $authorTasks задачи автора
 * @property Task[] $executorTasks задачи исполнителя
 * @Property Notice[] $notices уведомления
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'surname', 'name'], 'required'],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 25],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 50],
            [['email'], 'unique'],
        ];
    }
    /**
     * Обработка перед сохранением
     * @param bool $insert признак вставки
     * @return bool
     */
    public function beforeSave($insert) {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'email' => 'Email',
            'password' => 'Пароль',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorTasks()
    {
        return $this->hasMany(Task::class, ['authorId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Task::class, ['executorId' => 'id']);
    }    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::class, ['userId' => 'id']);
    }
    
}
