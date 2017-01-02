<?php

use app\models\Gate;
use app\models\Transport;
use app\models\Transaction;
use app\models\TransportPrice;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Transaction */
/* @var $form ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?php
	$gates = ArrayHelper::map(Gate::find()->where(['gate_type'=>Gate::GATE_TYPE_IN])->active()->all(), 'id', 'name');
    $selectOptions = ['data'=>$gates, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--', 'tabindex'=>1]];
    ?>
    <?= $form->field($model, 'gate_in_id')->widget(Select2::className(), $selectOptions) ?>

    <?php
	$transportPrices = ArrayHelper::map(TransportPrice::find()->where(['transport_id'=>Transport::TRANSPORT_REGULAR])->active()->all(), 'id', 'transportWithCode');
    $selectOptions = ['data'=>$transportPrices, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--', 'tabindex'=>2]];
    ?>
    <?= $form->field($model, 'transport_price_id')->widget(Select2::className(), $selectOptions) ?>
	
	<?= $form->field($model, 'time_in')->widget(DateTimePicker::classname(), [
		'type' => DateTimePicker::TYPE_INPUT,
		'language' => '',
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'yyyy-mm-dd hh:ii:ss',
		],
		'options' => [
			'value' => date('Y-m-d H:i:s'),
			'tabindex' => 3
		],
	]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Simpan (End / Enter)') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'button-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
	
	$('#transaction-gate_in_id').focus();
	
	$(document).keydown(function(e) {
		var enterKey = 13;
		
		// submit
		if(e.keyCode == enterKey || e.keyCode == 35) {
			$('#button-submit').click();
		}
		
	});

", View::POS_END, 'transaction-create-form');