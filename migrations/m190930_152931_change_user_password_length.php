<?php

use yii\db\Migration;

/**
 * Миграция изменения длины пароля
 */
class m190930_152931_change_user_password_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'password', 'varchar(64)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user', 'password', 'varchar(25)');
    }    
}
