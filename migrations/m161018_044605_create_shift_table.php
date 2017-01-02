<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shift`.
 */
class m161018_044605_create_shift_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('shift', [
            'id' => $this->primaryKey(),
            'name' => $this->char(100),
            'start_time' => $this->time(),
            'end_time' => $this->time(),
            'status' => $this->integer()->comment('1=Active;0=Inactive'),
            'created_at' => $this->datetime()->null(),
            'updated_at' => $this->datetime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('shift');
    }
}
