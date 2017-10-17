<?php

use app\helpers\StringHelper;
use yii\helpers\Html;

$this->title = 'Laporan Transaksi Bulanan';

$listYears = [];
foreach (range(date('Y') - 3, date('Y')) as $key => $value) {
	$listYears[$value] = $value;
}
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?= $this->title ?></h3>
	</div>
	<div class="panel-body">
        <div class="row only-print-disable">
            <div class="col-md-6">
                <?= Html::beginForm(['report/transaction-monthly'], 'get') ?>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="month">Bulan:</label>
							<?=	Html::dropDownList('month', Yii::$app->request->get('month', null), StringHelper::listIndoMonths(), [
								'class' => 'form-control', 
								'prompt' => 'Pilih Bulan',
								'id' => 'month',
							]) ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="year">Tahun:</label>
							<?=	Html::dropDownList('year', Yii::$app->request->get('year', null), $listYears, [
								'class' => 'form-control', 
								'prompt' => 'Pilih Tahun',
								'id' => 'year',
							]) ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<br/>
							<?= Html::submitInput('Submit', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
				</div>
                <?= Html::endForm() ?>
            </div>
            <div class="col-md-6 text-right">
                <?= Html::a("Print", [
					'report/transaction-monthly-print', 
					'month' => Yii::$app->request->get('month', ''),
					'year' => Yii::$app->request->get('year', ''),
					], ['class' => 'btn btn-primary']) ?><br/><br/>
            </div>
        </div>
        
		<?= $this->render('_list-transaction-monthly', []) ?>
	</div>
</div>