<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class m161018_050126_create_transaction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'code' => $this->char(100),
            'police_number' => $this->char(100),
            'gate_in_id' => $this->integer(),
            'time_in' => $this->datetime(),
            'gate_out_id' => $this->integer()->null(),
            'time_out' => $this->datetime()->null(),
            'picture' => $this->string(200)->null(),
            'status' => $this->integer()->comment('1=Entry;2=Exit'),
            'payment_status' => $this->integer()->comment('1=Draft;5=Waiting;10=Paid'),
            'transport_price_id' => $this->integer(),
            'vehicle_id' => $this->integer(),
            'payment_id' => $this->integer()->null(),
            'voucher_id' => $this->integer()->null(),
            'final_amount' => $this->decimal(14,2)->null(),
            'created_at' => $this->datetime()->null(),
            'updated_at' => $this->datetime()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
		
		$this->createIndex('transport_price_id','transaction','transport_price_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('transaction');
    }
}
