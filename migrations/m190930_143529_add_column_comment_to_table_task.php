<?php

use yii\db\Migration;

/**
 * Миграция добавления комментария в задачи
 */
class m190930_143529_add_column_comment_to_table_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'comment', 'varchar(1000)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task', 'comment');
    }    
}
