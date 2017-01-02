<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m161018_040902_create_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'class' => $this->string(100)->null(),
            'description' => $this->string(600),
            'status' => $this->integer()->comment('1=Active;0=Inactive'),
            'created_at' => $this->datetime()->null(),
            'updated_at' => $this->datetime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
		
		$this->insert('payment', [
			'name' => 'TUNAI',
			'class' => null,
			'description' => 'Jenis pembayaran langsung tunai',
			'status' => 1,
			'created_at' => '2016-10-07 05:40:45',
			'updated_at' => null,
			'created_by' => 1,
			'updated_by' => 1
		]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment');
    }
}
