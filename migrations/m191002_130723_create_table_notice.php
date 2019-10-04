<?php

use yii\db\Migration;

/**
 * Создание таблицы уведомлений
 */
class m191002_130723_create_table_notice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notice', [
            'id' => $this->primaryKey()->comment('ИД'),
            'taskId' => $this->integer()->notNull()->comment('ИД задачи'),
            'userId' => $this->integer()->notNull()->comment('ИД пользователя'),
            'dateIn' => $this->dateTime()->notNull()->comment('Время получения'),
            'event' => $this->string()->notNull()->comment('Событие уведомления'),
            'actual' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Время получения'),
        ]);
        $this->addForeignKey('fk_notice_taskId', 'notice', 'taskId', 'task', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_notice_userId', 'notice', 'userId', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('notice');
    }    
}
