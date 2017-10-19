<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\JsExpression;

$this->title = 'Rekapitulasi Parkir Bulanan';

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
                <?= Html::beginForm(['report/transaction-monthly-recapitulation'], 'get') ?>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="from_date">Dari:</label>
							<?= DatePicker::widget([
								'name' => 'from_date', 
								'value' => Yii::$app->request->get('from_date'),
								'dateFormat' => 'php:Y-m',
								'clientOptions' => [
									'autoClose' => true,
									'changeMonth' => true,
									'changeYear' => true,
									'showButtonPanel' => true,
									'onClose' => new \yii\web\JsExpression("function(dateText, inst) {
											$('#to_date').datepicker('option', 'minDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
											$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
											}"),
								], 
								'options' => [
									'class' => 'form-control',
									'id' => 'from_date',
								]
							]) ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="to_date">Sampai:</label>
							<?= DatePicker::widget([
								'name' => 'to_date', 
								'value' => Yii::$app->request->get('to_date'),
								'dateFormat' => 'php:Y-m',
								'clientOptions' => [
									'autoClose' => true,
									'changeMonth' => true,
									'changeYear' => true,
									'showButtonPanel' => true,
									'onClose' => new \yii\web\JsExpression("function(dateText, inst) {
											$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
											}"),
								], 
								'options' => [
									'class' => 'form-control',
									'id' => 'to_date',
								]
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
					'report/transaction-monthly-recapitulation-print', 
					'from_date' => Yii::$app->request->get('from_date', ''),
					'to_date' => Yii::$app->request->get('to_date', ''),
					], ['class' => 'btn btn-primary']) ?><br/><br/>
            </div>
        </div>
        
		<?= $this->render('_list-transaction-monthly-recapitulation', []) ?>
	</div>
</div>
<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>