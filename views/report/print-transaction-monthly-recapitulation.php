<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Rekapitulasi Parkir Bulanan';

?>

<div class="wrapper">
	<?= $this->render('_list-transaction-monthly-recapitulation', []) ?>
</div>
<?= Html::beginForm(Url::to(['report/transaction-monthly-recapitulation']), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>

<style>
	.wrapper {
		width: 1024px !important;
	}
</style>