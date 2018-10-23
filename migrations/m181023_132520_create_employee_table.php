<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m181023_132520_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'department_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employee');
    }
}
