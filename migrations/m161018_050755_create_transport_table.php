<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transport`.
 */
class m161018_050755_create_transport_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('transport', [
            'id' => $this->primaryKey(),
            'name' => $this->char(100),
            'description' => $this->varchar(600),
            'status' => $this->integer()->comment('1=Active;0=Inactive'),
            'created_at' => $this->datetime()->null(),
            'updated_at' => $this->datetime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
		
		$this->insert('{{%transport}}',['id'=>'1','name'=>'Regular','description'=>'Transport biasa','status'=>'1','created_at'=>'2016-10-05 17:09:00','updated_at'=>'','created_by'=>'1','updated_by'=>'']);
		$this->insert('{{%transport}}',['id'=>'2','name'=>'Member','description'=>'Transport yang memiliki voucher','status'=>'1','created_at'=>'2016-10-05 17:09:00','updated_at'=>'','created_by'=>'1','updated_by'=>'']);
		$this->insert('{{%transport}}',['id'=>'3','name'=>'Employee','description'=>'Transport khusus untuk karyawan, dan gratis','status'=>'1','created_at'=>'2016-10-05 17:09:00','updated_at'=>'','created_by'=>'1','updated_by'=>'']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('transport');
    }
}
