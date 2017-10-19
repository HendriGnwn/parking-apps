<?php

/* @var $this View */

use app\helpers\FormatConverter;
use app\models\Payment;
use app\models\Setting;
use app\models\Transaction;
use app\models\User;
use app\models\Vehicle;
use yii\web\View;
$listVehicles = Vehicle::find()->active()->all();
$fromDate = Yii::$app->request->get('from_date');
$toDate = Yii::$app->request->get('to_date');
$totalVehicle = [];
foreach ($listVehicles as $model) : 
	$totalVehicle[$model->id]['vehicle_id'] = 0;
	$totalVehicle[$model->id]['final_amount'] = 0;
endforeach;
$totalAllAmount = 0;
$totalAllVehicle = 0;
?>

<div class="row only-print-enable">
    <div class="col-md-12 text-center">
        <h4><strong>REKAP PARKIR BULANAN</strong></h4><br/>
    </div>
    
    <div class="text-left col-md-12">
		<span>Periode: <?= FormatConverter::formatIndoDate($fromDate . '-01', '%d %B %Y') ?> s/d <?= FormatConverter::formatIndoDate(date("Y-m-t", strtotime($toDate)), '%d %B %Y') ?></span><br/>
        <span>Dicetak Oleh: <?= User::findOne(Yii::$app->user->id)->username ?></span><br/>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" rowspan="2" width="20%">Lama Parkir</th>
            <?php foreach ($listVehicles as $model) : ?>
                <th class="text-center" colspan="2">
                    <?= $model->name ?>
                </th>
            <?php endforeach; ?>
			<th class="text-center" colspan="2">Grand Total</th>
        </tr>
        <tr>
            <?php foreach ($listVehicles as $model) : ?>
                <th class="text-center" width="12%">Jml</th>
                <th class="text-center" width="12%">Nilai</th>
            <?php endforeach; ?>
			<th class="text-center" width="12%">Jml</th>
            <th class="text-center" width="12%">Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		if ($fromDate != null && $toDate != null) {
			foreach (app\helpers\StringHelper::listOldParkings() as $key => $item) : 
		?>
		<tr>
			<td><?= $item['name'] ?></td>
			<?php 
			foreach ($listVehicles as $model) : 
				$queryTransaction = Transaction::find()
					->select([
						'SUM(vehicle_id) as vehicle_id',
						'SUM(final_amount) as final_amount',
					])
					->andWhere([
						'payment_status' => Transaction::PAYMENT_STATUS_PAID,
						'status' => Transaction::STATUS_EXIT,
						'vehicle_id' => $model->id,
					])
					->andWhere([
						'>=', "DATE_FORMAT(time_in, '%Y-%m')", $fromDate,
					])
					->andWhere([
						'<=', "DATE_FORMAT(time_out, '%Y-%m')", $toDate,
					])
					->andWhere([
						$item['compare'], 'timestampdiff(HOUR, time_in, time_out)', $item['value']
					])
					->groupBy([
						'timestampdiff(HOUR, time_in, time_out)'
					])
					->one();
			
				$sumVehicle = ($queryTransaction['vehicle_id']) ? $queryTransaction['vehicle_id'] : 0;
				$sumAmount = ($queryTransaction['final_amount']) ? $queryTransaction['final_amount'] : 0;
				$totalVehicle[$model->id]['vehicle_id'] += $sumVehicle;
				$totalVehicle[$model->id]['final_amount'] += $sumAmount;
			?>
			<td class="text-center" width="12%"><?= $sumVehicle ?></td>
            <td class="text-right" width="12%"><?= FormatConverter::rupiah($sumAmount) ?></td>
            <?php 
			endforeach; 
						
			$querySubTotal = Transaction::find()
					->select([
						'SUM(vehicle_id) as vehicle_id',
						'SUM(final_amount) as final_amount',
					])
					->andWhere([
						'payment_status' => Transaction::PAYMENT_STATUS_PAID,
						'status' => Transaction::STATUS_EXIT,
					])
					->andWhere([
						'>=', "DATE_FORMAT(time_in, '%Y-%m')", $fromDate,
					])
					->andWhere([
						'<=', "DATE_FORMAT(time_out, '%Y-%m')", $toDate,
					])
					->andWhere([
						$item['compare'], 'timestampdiff(HOUR, time_in, time_out)', $item['value']
					])
					->groupBy([
						'timestampdiff(HOUR, time_in, time_out)'
					])
					->one();
				$sumVehicle = ($querySubTotal['vehicle_id'] != null) ? $querySubTotal['vehicle_id'] : 0;
				$sumAmount = ($querySubTotal['final_amount'] != null) ? $querySubTotal['final_amount'] : 0;
				$totalAllVehicle += $sumVehicle;
				$totalAllAmount += $sumAmount;
			?>
			<td class="text-center" width="12%"><?= $sumVehicle ?></td>
            <td class="text-right" width="12%"><?= FormatConverter::rupiah($sumAmount) ?></td>
		</tr>
		<?php 
			endforeach;
		}
		?>
		<tr>
			<th>TOTAL</th>
			<?php foreach ($listVehicles as $model) : ?>
			<th><?= $totalVehicle[$model->id]['vehicle_id'] ?></th>
			<th><?= FormatConverter::rupiah($totalVehicle[$model->id]['final_amount']) ?></th>
			<?php endforeach; ?>
			<th><?= $totalAllVehicle ?></th>
			<th><?= FormatConverter::rupiah($totalAllAmount) ?></th>
		</tr>
    </tbody>
</table>