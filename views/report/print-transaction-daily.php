<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Laporan Transaksi Harian';

?>

<div class="wrapper">
	<?= $this->render('_list-transaction-daily', []) ?>
</div>
<?= Html::beginForm(Url::to(['report/transaction-daily']), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>