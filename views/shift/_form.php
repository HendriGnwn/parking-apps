<?php

use app\models\Shift;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Shift */
/* @var $form ActiveForm */
?>

<div class="shift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::classname(), [
		'type' => DateTimePicker::TYPE_INPUT,
		'language' => '',
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'hh:ii:ss',
		],
	]) ?>

    <?= $form->field($model, 'end_time')->widget(DateTimePicker::classname(), [
		'type' => DateTimePicker::TYPE_INPUT,
		'language' => '',
		'pluginOptions' => [
			'autoclose'=>true,
			'format' => 'hh:ii:ss',
		],
	]) ?>

	<?php
    $selectOptions = ['data'=>Shift::statusLabels(), 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'status')->widget(Select2::className(), $selectOptions) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
