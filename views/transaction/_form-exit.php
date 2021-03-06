<?php

use app\models\Gate;
use app\models\Payment;
use app\models\Transaction;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Transaction */
/* @var $form ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(['id'=>'transaction']); ?>
	
	<div class="col-xs-12 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Proses Cek</div>
			<div class="panel-body">
				<?= $form->field($model, 'time_out')->widget(DateTimePicker::classname(), [
					'type' => DateTimePicker::TYPE_INPUT,
					'language' => '',
					'pluginOptions' => [
						'autoclose'=>true,
						'format' => 'yyyy-mm-dd hh:ii:ss',
					],
					'options' => [
						'value' => date('Y-m-d H:i:s'),
					],
				]) ?>
				
				<?= $form->field($model, 'police_number')->textInput(['maxlength' => true, 'tabindex' => 1]) ?>

				<?= $form->field($model, 'code')->textInput(['maxlength' => true, 'tabindex' => 2]) ?>

			</div>
			<div class="panel-footer">
				<?=	Html::button('Cek Transaksi (Enter)', ['class'=>'btn btn-primary', 'id'=>'transaction-check-button']) ?>
			</div>
		</div>
	</div>
	
	<div class="col-xs-12 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Detail</div>
			<div class="panel-body">
				<?php
					$gates = ArrayHelper::map(Gate::find()->where(['gate_type'=>Gate::GATE_TYPE_OUT])->active()->all(), 'id', 'name');
					$selectOptions = ['data'=>$gates, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--', 'tabindex' => 3]];
					?>
					<?= $form->field($model, 'gate_out_id')->widget(Select2::className(), $selectOptions) ?>

					<?php
					$payments = ArrayHelper::map(Payment::find()->active()->all(), 'id', 'name');
					$selectOptions = ['data'=>$payments, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--', 'tabindex' => 4]];
					?>
					<?= $form->field($model, 'payment_id')->widget(Select2::className(), $selectOptions) ?>

					<?= $form->field($model, 'voucher_id')->hiddenInput()->label(false) ?>
				
					<?= $form->field($model, 'transport_price_id')->hiddenInput()->label(false) ?>

					<?= $form->field($model, 'final_amount')->hiddenInput()->label(false) ?>
			</div>
			<div class="panel-footer">
				<table class="table">
					<tr>
						<td width="50%"><h4><?= $model->getAttributeLabel('final_amount') ?></h4></td>
						<td width="5%"><h4>:</h4></td>
						<td align="right"><h4 id="final-amount-label" style="color:#FF6666;"></h4></td>
					</tr>
					<tr>
						<td width="50%">Keterangan</td>
						<td width="5%">:</td>
						<td align="right"><p id="description-label"></p></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-xs-12 col-md-12">
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan (End)') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'button-submit', 'tabindex' => 5]) ?>
    </div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
	
	var formData = $('#transaction').serializeArray(),
		checkButton = $('#transaction-check-button'),
		code = $('#transaction-code'),
		policeNumber = $('#transaction-police_number'),
		transportPrice = $('#transaction-transport_price_id'),
		timeOut = $('#transaction-time_out'),
		voucherId = $('#transaction-voucher_id'),
		finalAmount = $('#transaction-final_amount'),
		finalAmountLabel = $('#final-amount-label'),
		descLabel = $('#description-label');
		
	policeNumber.focus();
	
	checkButton.click(function() {
		if (code.val() == '' || policeNumber.val() == '') {
			alert('Kode dan Nomor Polisi harus diisi.');
			code.focus();
			return false;
		}
		
		var data = {code: code.val(), policeNumber: policeNumber.val(), timeOut: timeOut.val()};
		$.post('".Url::to(['transaction/ajax-calculate-by-code-and-police-number'])."', data).done(function (result) {
			console.log(result);
			if(result) {
				obj = JSON.parse(result);
				
				transportPrice.val(obj.transport_price_id);
				voucherId.val(obj.voucher_id);
				finalAmount.val(obj.final_amount);
				finalAmountLabel.text(rupiah(obj.final_amount));
				
				$.post('".Url::to(['voucher/ajax-get-data-with-relate-transport-price'])."', {id:obj.voucher_id}).done(function (result) {
					if(result) {
						objVoucher = JSON.parse(result);
						descLabel.text(objVoucher.transportPrice.transportWithCode + ' ' + objVoucher.code);
					} else {
						descLabel.text('Regular - ' + obj.vehicle.name);
					}
				});
				
			} else {
				transportPrice.val('');
				voucherId.val('');
				finalAmount.val('');
				finalAmountLabel.text('');
				descLabel.text('');
				alert('Data tidak ditemukan. Silahkan cek kembali Kode yang anda input.');
			}
		});
	});
	
	function rupiah(value) {
		var rev     = parseInt(value, 10).toString().split('').reverse().join('');
		var rev2    = '';
		for(var i = 0; i < rev.length; i++){
			rev2  += rev[i];
			if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
				rev2 += '.';
			}
		}
		return 'Rp. ' + rev2.split('').reverse().join('');
	}
	
	$('#button-submit').click(function(){
		if (finalAmount.val() == '') {
			alert('Anda belum mengklik Cek Transaksi.');
			return false;
		}
		
		$('#transaction').submit();
	});
	
	$(document).keydown(function(e) {
		var enterKey = 13;
		var endKey = 35;
		
		// cek transaksi
		if(e.keyCode == enterKey) {
			checkButton.click();
		}
		
		// submit
		if(e.keyCode == endKey) {
			$('#button-submit').click();
		}
	});
	
	$('#transaction').on('keyup keypress', function(e){
		if(e.which == 13) {
			e.preventDefault();
			return false;
		}
	});
	
", View::POS_END, 'transaction-check-button');