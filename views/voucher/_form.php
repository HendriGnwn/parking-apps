<?php

use app\models\Transport;
use app\models\TransportPrice;
use app\models\Voucher;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Voucher */
/* @var $form ActiveForm */
?>

<div class="voucher-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php
    $selectOptions = ['data'=>Voucher::voucherTypeLabels(), 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'voucher_type')->widget(Select2::className(), $selectOptions) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php
	$transportPrices = ArrayHelper::map(TransportPrice::find()->where(['!=', 'transport_id', Transport::TRANSPORT_REGULAR])->active()->all(), 'id', 'transportWithCode');
    $selectOptions = ['data'=>$transportPrices, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'transport_price_id')->widget(Select2::className(), $selectOptions) ?>
	
    <?= $form->field($model, 'limit')->textInput() ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
		//'language' => 'ru',
		'dateFormat' => 'yyyy-MM-dd',
		'clientOptions' => [
			'minDate' => 0,
		],
		'options' => [
			'class' => 'form-control',
		]
	]) ?>
	
	<?php
    $selectOptions = ['data'=>Voucher::voucherTypeAmountLabels(), 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'voucher_type_amount')->widget(Select2::className(), $selectOptions) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?php
    $selectOptions = ['data'=>Voucher::statusLabels(), 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'status')->widget(Select2::className(), $selectOptions) ?>
	
	<?= $form->field($model, 'vehicle_id')->hiddenInput()->label(false) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php 
	$this->registerJs("
		
		var voucherType = $('#voucher-voucher_type'),
			transportPrice = $('#voucher-transport_price_id'),
			limit = $('#voucher-limit'),
			amount = $('#voucher-amount'),
			voucherTypeAmount = $('#voucher-voucher_type_amount'),
			startDate = $('#voucher-start_date'),
			endDate = $('#voucher-end_date'),
			vehicleId = $('#voucher-vehicle_id');
		
		$(transportPrice).change(function() {
			$.ajax({
				type: 'POST',
				data: {id:transportPrice.val()},
				url: '". Url::to(['transport-price/ajax-get-data']) ."',
				success: function (data) {
					if(data) {
						obj = JSON.parse(data);
						
						limit.val(obj.limit);
						voucherTypeAmount.val(".Voucher::VOUCHER_TYPE_AMOUNT_FIX.").trigger('change');
						amount.val(obj.amount);
						vehicleId.val(obj.vehicle_id);
					}
				},
			});
		});
		
		$(voucherType).change(function() {
			var divTransportPrice = $('.field-voucher-transport_price_id'),
				labelCode = $('.field-voucher-code label');
			if (voucherType.val() == '".Voucher::VOUCHER_TYPE_CODE."') {
				labelCode.text('Kode');
				divTransportPrice.hide();
			} else {
				labelCode.text('Nomor Polisi');
				divTransportPrice.show();
			}
		});
		
		
	
	", View::POS_END, 'voucher-form');