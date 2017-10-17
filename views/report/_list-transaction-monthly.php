<?php

/* @var $this View */

use app\helpers\FormatConverter;
use app\models\Payment;
use app\models\Setting;
use app\models\Transaction;
use app\models\User;
use app\models\Vehicle;
use yii\web\View;

$listPayments = Payment::find()->active()->all();
$listVehicles = Vehicle::find()->active()->all();

$date = Yii::$app->request->get('year') . '-' . Yii::$app->request->get('month');

$queryReport = Transaction::find()
	->andWhere([
		'payment_status' => Transaction::PAYMENT_STATUS_PAID,
		'status' => Transaction::STATUS_EXIT,
	])
	->andWhere([
		'>=', "DATE_FORMAT(time_in, '%Y-%m')", $date,
	])
	->andWhere([
		'<=', "DATE_FORMAT(time_out, '%Y-%m')", $date,
	]);
$reports = $queryReport
    ->select([
		'MIN(time_in) AS time_in',
		'MAX(time_out) AS time_out',
		'payment_id',
		'transport_price_id',
		'created_by',
	])
	->groupBy([
		"DATE_FORMAT(time_in, '%Y-%m-%d')",
		'transport_price_id',
	])
	->all();

?>

<div class="row only-print-enable">
    <div class="col-md-12">
        <strong><?= Setting::getAppName() ?></strong><br/>
        <span>Dicetak Oleh: <?= User::findOne(Yii::$app->user->id)->username ?></span><br/>
    </div>
    
    <div class="text-right col-md-12">
        <strong>LAPORAN BULANAN PENDAPATAN PARKIR</strong><br/>
        <span>Periode: <?= FormatConverter::formatIndoDate($date, '%B %Y') ?></span><br/>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" rowspan="2" width="20%">Tanggal</th>
            <th class="text-center" rowspan="2">Keterangan</th>

            <?php foreach ($listPayments as $model) : ?>
                <th class="text-center" colspan="2">
                    <?= $model->name ?>
                </th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($listPayments as $model) : ?>
                <th class="text-center" width="12%">Jml</th>
                <th class="text-center" width="12%">Nilai</th>
            <?php endforeach; ?>
        </tr>

    </thead>
    <tbody>
        <?php $varTemp = null; ?>
        <?php foreach ($reports as $report) : ?>
            <tr>
                <?php if (FormatConverter::formatIndoDate($report->time_in, '%Y-%m-%d') == $varTemp) { ?>
                    <td></td>
                <?php
                } else {
                ?>
                    <td><?= FormatConverter::formatIndoDate($report->time_in, '%A, %d %B %Y') ?></td>
                <?php
                }
                $varTemp = FormatConverter::formatIndoDate($report->time_in, '%Y-%m-%d');
                ?>
                <td>
                    <?= $report->transportPrice->transport->name . ' - ' . $report->transportPrice->name ?>
                </td>
                <?php
                foreach ($listPayments as $model) :
                    $queryPayment = Transaction::find()
                            ->andWhere([
								'payment_status' => Transaction::PAYMENT_STATUS_PAID,
								'status' => Transaction::STATUS_EXIT,
								"DATE_FORMAT(time_in, '%Y-%m-%d')" => $varTemp,
								'transport_price_id' => $report->transport_price_id,
								'payment_id' => $model->id,
							])
							->andWhere([
								'>=', "DATE_FORMAT(time_in, '%Y-%m')", $date,
							])
							->andWhere([
								'<=', "DATE_FORMAT(time_out, '%Y-%m')", $date,
							]);
                    ?>
                    <td class="text-center">
                        <?= $queryPayment->count() ?>
                    </td>
                    <td class="text-right">
                        <?= FormatConverter::rupiah($queryPayment->sum('final_amount')) ?>
                    </td>
                <?php endforeach; ?>
            </tr>
			<?php 
			foreach ($listVehicles as $vehicle) : 
			   $reportVehicle = Transaction::find()
					->andWhere([
						'payment_status' => Transaction::PAYMENT_STATUS_PAID,
						'status' => Transaction::STATUS_EXIT,
						"DATE_FORMAT(time_in, '%Y-%m-%d')" => $varTemp,
						'vehicle_id' => $vehicle->id,
					])
					->andWhere([
						'>=', "DATE_FORMAT(time_in, '%Y-%m')", $date,
					])
					->andWhere([
						'<=', "DATE_FORMAT(time_out, '%Y-%m')", $date,
					]);
			?>
			<tr>
				<td></td>
				<td>SUB TOTAL <?= $vehicle->name ?></td>
				<td class="text-center"><?= $reportVehicle->count('vehicle_id') ?></td>
				<td class="text-right"><?= FormatConverter::rupiah($reportVehicle->sum('final_amount')) ?></td>
			</tr>
			<?php endforeach; ?>
			
				
        <?php endforeach; ?>
		<?= (count($reports) <= 0) ? "<tr><td colspan='4'>No result data</td>" : "" ?>
    </tbody>
</table>