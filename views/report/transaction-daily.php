<?php

use app\models\Payment;

$this->title = 'Laporan Transaksi Harian';

$listPayments = Payment::find()->active()->all();

$startDate = Yii::$app->request->get('start', '2016-11-12');
$endDate = Yii::$app->request->get('end', '2016-11-12');

$reports = app\models\Transaction::find()
	->select([
		'MIN(time_in) AS time_in',
		'MAX(time_out) AS time_out',
		'payment_id',
		'transport_price_id',
		'created_by',
	])
	->where([
		'payment_status' => app\models\Transaction::PAYMENT_STATUS_PAID,
		'status' => app\models\Transaction::STATUS_EXIT,
		"DATE_FORMAT(time_in, '%Y-%m-%d')" => $startDate,
		"DATE_FORMAT(time_out, '%Y-%m-%d')" => $endDate,
	])
	->groupBy([
		'created_by',
		'transport_price_id',
		'payment_id',
	])
	->all();

?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?= $this->title ?></h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2">User</th>
					<th rowspan="2">Awal Transaksi</th>
					<th rowspan="2">Akhir Transaksi</th>
					<th rowspan="2">Keterangan</th>

					<?php foreach ($listPayments as $model) : ?>
						<th colspan="2">
							<?= $model->name ?>
						</th>
					<?php endforeach; ?>
				</tr>
				<tr>
					<?php foreach ($listPayments as $model) : ?>
						<th>Jml</th>
						<th>Nilai</th>
					<?php endforeach; ?>
				</tr>

			</thead>
			<tbody>
				<?php $varTemp = null; ?>
				<?php foreach($reports as $report) : ?>
				<?php
				$query = app\models\Transaction::find()
					->where([
						'payment_status' => app\models\Transaction::PAYMENT_STATUS_PAID,
						'status' => app\models\Transaction::STATUS_EXIT,
						'created_by' => $report->created_by,
						"DATE_FORMAT(time_in, '%Y-%m-%d')" => $startDate,
						"DATE_FORMAT(time_out, '%Y-%m-%d')" => $endDate,
					]);
				?>
				<tr>
					<?php if ($report->created_by == $varTemp) { ?>
						<td></td>
						<td></td>
						<td></td>
					<?php
					} else { 
					?>
						<td><?= $report->createdBy->username ?></td>
						<td><?= $query->min('time_in') ?></td>
						<td><?= $query->min('time_out') ?></td>
					<?php 
					} 
					$varTemp = $report->created_by;
					?>
					<td>
					<?= $report->transportPrice->transport->name . ' - ' . $report->transportPrice->name ?>
					</td>
					<?php foreach ($listPayments as $model) : ?>
						<th>
							<?= app\models\Transaction::find()
							->andWhere([
								'payment_status' => app\models\Transaction::PAYMENT_STATUS_PAID,
								'status' => app\models\Transaction::STATUS_EXIT,
								'created_by' => $report->created_by,
								'transport_price_id' => $report->transport_price_id,
								'payment_id' => $model->id,
								"DATE_FORMAT(time_in, '%Y-%m-%d')" => $startDate,
								"DATE_FORMAT(time_out, '%Y-%m-%d')" => $endDate,
							])
							->count()
							?>
						</th>
						<th>
							<?= app\models\Transaction::find()
							->andWhere([
								'payment_status' => app\models\Transaction::PAYMENT_STATUS_PAID,
								'status' => app\models\Transaction::STATUS_EXIT,
								'created_by' => $report->created_by,
								'transport_price_id' => $report->transport_price_id,
								'payment_id' => $model->id,
							])
							->andFilterCompare('DATE_FORMAT(time_in, "%Y-%m-%d")', $startDate, '=')
							->andFilterCompare('DATE_FORMAT(time_out, "%Y-%m-%d")', $endDate, '=')
							->sum('final_amount')
							?>
						</th>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>