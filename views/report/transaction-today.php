<?php

use app\helpers\FormatConverter;
use app\models\Transaction;
use yii\helpers\Html;
use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Laporan Transaksi';
$attribute = (object)(new Transaction())->attributeLabels();

$no = 1;
?>

<div class="text-center">
	<span><?= $user->username ?> - <?= FormatConverter::formatIndoDate(date('Y-m-d'), '%d %b %Y') ?></span>
	<br/>
	<table class="table table-bordered" border="1">
		<tr>
			<th>No</th>
			<th><?= $attribute->police_number ?></th>
			<th><?= $attribute->time_in ?></th>
			<th><?= $attribute->time_out ?></th>
			<th><?= $attribute->final_amount ?></th>
		</tr>
		<?php foreach($dataProvider->models as $model) { ?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?= $model->police_number ?></td>
			<td><?= $model->time_in ?></td>
			<td><?= $model->time_out ?></td>
			<td><?= $model->getFormattedFinalAmount() ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th align="right" colspan="4">Total</th>
			<th><?= $searchModel->getTotalAmount($dataProvider) ?></th>
		</tr>
	</table>
	---------------------------------------
</div>
<?= Html::beginForm(Url::to(['transaction/create']), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>