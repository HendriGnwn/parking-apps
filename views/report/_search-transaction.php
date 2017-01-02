<?php

use app\models\search\TransactionSearch;
use kartik\select2\Select2;
use app\models\Transaction;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model TransactionSearch */
/* @var $form ActiveForm */
?>

<div class="transaction-search">
	
	<?php $form = ActiveForm::begin([
        'method' => 'get',
    ]); ?>
	<div class="row">
		
		<div class="col-md-2">
			<?= $form->field($model, 'filter_date')->label('Filter Tanggal')->dropDownList(Transaction::filterDatetimes()) ?>
		</div>
		
		<div class="col-md-2">
			<?= $form->field($model, 'from_date')->label('Dari')->widget(DatePicker::className(), [
				'dateFormat' => 'php:Y-m-d',
				'clientOptions' => [
					'autoClose' => true,
					'changeMonth' => true,
					'changeYear' => true,
					'onSelect' => new JsExpression("function() {
								var minEndDate = $('#transactionsearch-from_date').datepicker('getDate');
								minEndDate.setDate(minEndDate.getDate() + 0);

								$('#transactionsearch-to_date').datepicker('option', 'minDate', minEndDate);
							 }"),
				],
				'options' => ['class'=>'form-control'],
			]) ?>
		</div>

		<div class="col-md-2">
			<?= $form->field($model, 'to_date')->label('Sampai')->widget(DatePicker::className(), [
				'dateFormat' => 'php:Y-m-d',
				'clientOptions' => [
					'autoClose' => true,
					'changeMonth' => true,
					'changeYear' => true,
					'onSelect' => new JsExpression("function() {
								var startDate = $('#transactionsearch-from_date'),
									endDate = $('#transactionsearch-to_date');

								if (startDate.val() == '') {
									alert('Select Start Date first ..');
									endDate.val('');
									startDate.focus();
									return false;
								}
							 }"),
				],
				'options' => ['class'=>'form-control'],
			]) ?>
		</div>
		<div class="col-md-2">
			<label>Pencarian</label>
			<div class="form-group">
				<?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;'.Yii::t('app', 'Cari'), ['class' => 'btn btn-primary']) ?>
				<?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
			</div>
			
		</div>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>
