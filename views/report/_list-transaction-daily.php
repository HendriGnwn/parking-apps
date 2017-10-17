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

$date = Yii::$app->request->get('date', '');

$queryReport = Transaction::find()
	->andWhere([
		'payment_status' => Transaction::PAYMENT_STATUS_PAID,
		'status' => Transaction::STATUS_EXIT,
		"DATE_FORMAT(time_in, '%Y-%m-%d')" => $date,
		"DATE_FORMAT(time_out, '%Y-%m-%d')" => $date,
	]);
$countQuantityTransaction = $queryReport->count();
$finalAmountTransaction = $queryReport->sum('final_amount');
$reports = $queryReport
    ->select([
		'MIN(time_in) AS time_in',
		'MAX(time_out) AS time_out',
		'payment_id',
		'transport_price_id',
		'created_by',
	])
	->groupBy([
		'created_by',
		'transport_price_id',
		'payment_id',
	])
	->all();

?>

<div class="row only-print-enable">
    <div class="col-md-12">
        <strong><?= Setting::getAppName() ?></strong><br/>
        <span>Dicetak Oleh: <?= User::findOne(Yii::$app->user->id)->username ?></span><br/>
    </div>
    
    <div class="text-right col-md-12">
        <strong>LAPORAN HARIAN PENDAPATAN PARKIR</strong><br/>
        <span>Tanggal: <?= $date ?></span><br/>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" rowspan="2">User</th>
            <th class="text-center" rowspan="2">Awal Transaksi</th>
            <th class="text-center" rowspan="2">Akhir Transaksi</th>
            <th class="text-center" rowspan="2">Keterangan</th>

            <?php foreach ($listPayments as $model) : ?>
                <th class="text-center" colspan="2">
                    <?= $model->name ?>
                </th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($listPayments as $model) : ?>
                <th class="text-center">Jml</th>
                <th class="text-center">Nilai</th>
            <?php endforeach; ?>
        </tr>

    </thead>
    <tbody>
        <?php $varTemp = null; ?>
        <?php foreach ($reports as $report) : ?>
            <?php
            $query = Transaction::find()
                    ->where([
                'payment_status' => Transaction::PAYMENT_STATUS_PAID,
                'status' => Transaction::STATUS_EXIT,
                'created_by' => $report->created_by,
                "DATE_FORMAT(time_in, '%Y-%m-%d')" => $date,
                "DATE_FORMAT(time_out, '%Y-%m-%d')" => $date,
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
                    <td><?= $query->max('time_out') ?></td>
                    <?php
                }
                $varTemp = $report->created_by;
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
                        'created_by' => $report->created_by,
                        'transport_price_id' => $report->transport_price_id,
                        'payment_id' => $model->id,
                        "DATE_FORMAT(time_in, '%Y-%m-%d')" => $date,
                        "DATE_FORMAT(time_out, '%Y-%m-%d')" => $date,
                    ]);
                    ?>
                    <th class="text-center">
                        <?= $queryPayment->count() ?>
                    </th>
                    <th class="text-right">
                        <?= FormatConverter::rupiah($queryPayment->sum('final_amount')) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th></th>
            <th colspan="3">SUB TOTAL</th>
            <th class="text-center"><?= $countQuantityTransaction ?></th>
            <th class="text-right"><?= FormatConverter::rupiah($finalAmountTransaction) ?></th>
        </tr>
        <?php 
        foreach ($listVehicles as $vehicle) : 
           $reportVehicle = Transaction::find()
                ->andWhere([
                    'payment_status' => Transaction::PAYMENT_STATUS_PAID,
                    'status' => Transaction::STATUS_EXIT,
                    "DATE_FORMAT(time_in, '%Y-%m-%d')" => $date,
                    "DATE_FORMAT(time_out, '%Y-%m-%d')" => $date,
                    'vehicle_id' => $vehicle->id,
                ]);
        ?>
        <tr>
            <th></th>
            <th colspan="2">SUB TOTAL</th>
            <th><?= $vehicle->name ?></th>
            <th class="text-center"><?= $reportVehicle->count('vehicle_id') ?></th>
            <th class="text-right"><?= FormatConverter::rupiah($reportVehicle->sum('final_amount')) ?></th>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="4">TOTAL</th>
            <th class="text-center"><?= $countQuantityTransaction ?></th>
            <th class="text-right"><?= FormatConverter::rupiah($finalAmountTransaction) ?></th>
        </tr>
    </tbody>
</table>