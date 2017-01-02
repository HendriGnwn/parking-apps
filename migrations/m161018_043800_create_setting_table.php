<?php

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class m161018_043800_create_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('setting', [
            'name' => $this->char(100),
            'value' => $this->text(),
            'label' => $this->char(100),
            'note' => $this->text()->null(),
        ]);
		
		$this->insert('{{%setting}}',['name'=>'admin_email','value'=>'hendri.gnw@gmail.com','label'=>'Hendri Gunawan','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'app_name','value'=>'Hendri Mall Parking','label'=>'Application Name','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'company_address','value'=>'Jl Ketapang No. 27 Jakarta Pusat','label'=>'Company Address','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'company_email','value'=>'hendri.gnw@gmail.com','label'=>'Company Email','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'company_name','value'=>'PT. Hendri Teknologi','label'=>'Company Name','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'company_phone','value'=>'021 9000081','label'=>'Company Phone','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'copyright','value'=>'© Hendri Gunawan','label'=>'Copyright','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'developer_email','value'=>'hendri.gnw@gmail.com','label'=>'Hendri Gunawan','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'send_mail','value'=>'1','label'=>'Send Mail','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'struct_entry_footer','value'=>'Jangan tinggalkan tiket dan barang berharga lainnya di kendaraan Anda. Segala kerusakan dan kehilangan Bukan Tanggung Jawab Pengelola Parkir.','label'=>'Struk masuk','note'=>'']);
		$this->insert('{{%setting}}',['name'=>'struct_exit_footer','value'=>'Terima Kasih atas kunjungan Anda','label'=>'Struk keluar','note'=>'']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('setting');
    }
}
