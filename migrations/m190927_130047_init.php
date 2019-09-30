<?php

use yii\db\Migration;

/**
 * Инициализация базы данных
 */
class m190927_130047_init extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('project', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(100)->notNull()->unique()->comment('Наименование')
        ]);

        $this->createTable('taskType', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(45)->notNull()->unique()->comment('Наименование')
        ]);
        $this->insert('taskType', ['id' => 1, 'name' => 'Ошибка']);
        $this->insert('taskType', ['id' => 2, 'name' => 'Улучшение']);
        $this->insert('taskType', ['id' => 3, 'name' => 'Консультация']);

        $this->createTable('user', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'surname' => $this->string(50)->notNull()->comment('Фамилия'),
            'name' => $this->string(50)->notNull()->comment('Имя'),
            'patronymic' => $this->string(50)->comment('Отчество'),
            'email' => $this->string(100)->notNull()->unique()->comment('Email'),
            'password' => $this->string(25)->notNull()->comment('Пароль'),
        ]);

        $this->createIndex('ix_user_email', 'user', 'email', true);

        $this->createTable('task', [
            'id' => $this->primaryKey()->comment('Идентификатор'),
            'projectId' => $this->integer()->notNull()->comment('ИД проекта'),
            'typeId' => $this->integer()->notNull()->comment('ИД типа'),
            'priority' => $this->smallInteger()->notNull()->comment('Приоретет'),
            'authorId' => $this->integer()->notNull()->comment('ИД автора'),
            'executorId' => $this->integer()->notNull()->comment('ИД исполнителя'),
            'status' => $this->smallInteger()->notNull()->comment('Статус'),
            'name' => $this->string(100)->notNull()->comment('Наименование'),
            'content' => $this->string(2000)->comment('Содержание'),
            'dateStart' => $this->dateTime()->notNull()->comment('Дата начала'),
            'dateEnd' => $this->dateTime()->comment('Дата конца'),
            'dateLimit' => $this->dateTime()->comment('Конечный срок'),
        ]);

        $this->addForeignKey('fk_task_projectId', 'task', 'projectId', 'project', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_task_typeId', 'task', 'typeId', 'taskType', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_task_authorId', 'task', 'authorId', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_task_executorId', 'task', 'executorId', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('project');
        $this->dropTable('taskType');
        $this->dropTable('user');
        $this->dropTable('task');
    }

}
