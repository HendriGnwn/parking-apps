<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Laporan Transaksi Bulanan';

?>

<div class="wrapper">
	<?= $this->render('_list-transaction-monthly', []) ?>
</div>
<?= Html::beginForm(Url::to(['report/transaction-monthly']), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>