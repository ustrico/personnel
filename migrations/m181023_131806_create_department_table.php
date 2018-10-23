<?php

use yii\db\Migration;

/**
 * Handles the creation of table `department`.
 */
class m181023_131806_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('department');
    }
}
