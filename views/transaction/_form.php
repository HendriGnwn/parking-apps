<?php

use app\models\Gate;
use app\models\Payment;
use app\models\Transaction;
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

    <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

    <?= $form->field($model, 'police_number')->textInput(['maxlength' => true]) ?>

    <?php
	$gates = ArrayHelper::map(Gate::find()->where(['gate_type'=>Gate::GATE_TYPE_IN])->active()->all(), 'id', 'name');
    $selectOptions = ['data'=>$gates, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'gate_in_id')->widget(Select2::className(), $selectOptions) ?>

    <?= $form->field($model, 'time_in')->widget(DateTimePicker::classname(), [
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

    <?php
	$gates = ArrayHelper::map(Gate::find()->where(['gate_type'=>Gate::GATE_TYPE_OUT])->active()->all(), 'id', 'name');
	$selectOptions = ['data'=>$gates, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
	?>
	<?= $form->field($model, 'gate_out_id')->widget(Select2::className(), $selectOptions) ?>

	<?php
	$payments = ArrayHelper::map(Payment::find()->active()->all(), 'id', 'name');
	$selectOptions = ['data'=>$payments, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
	?>
	<?= $form->field($model, 'payment_id')->widget(Select2::className(), $selectOptions) ?>

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

	<?php
	$options = Transaction::statusLabels();
	$selectOptions = ['data'=>$options, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
	?>
    <?= $form->field($model, 'status')->widget(Select2::className(), $selectOptions) ?>

    <?= $form->field($model, 'final_amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
