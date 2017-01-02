<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gate`.
 */
class m161018_035321_create_gate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$this->createTable('gate', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'gate_type' => $this->integer()->comment('1=Gate In;2=Gate Out'),
            'status' => $this->integer()->comment('1=Active;2=Inactive'),
            'created_at' => $this->datetime()->null(),
            'updated_at' => $this->datetime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
		
		$this->insert('{{%gate}}',['id'=>'1','name'=>'MASUK-1','gate_type'=>'1','status'=>'1','created_at'=>'2016-10-07 05:40:45','updated_at'=>'2016-10-07 05:44:09','created_by'=>'1','updated_by'=>'1']);
		$this->insert('{{%gate}}',['id'=>'2','name'=>'KELUAR-1','gate_type'=>'2','status'=>'1','created_at'=>'2016-10-10 16:25:30','updated_at'=>'','created_by'=>'1','updated_by'=>'1']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropTable('gate');
    }
}
