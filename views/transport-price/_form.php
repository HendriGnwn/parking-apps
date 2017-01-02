<?php

use app\models\Transport;
use app\models\TransportPrice;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model TransportPrice */
/* @var $form ActiveForm */
?>

<div class="transport-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
	$transports = ArrayHelper::map(Transport::find()->active()->all(), 'id', 'name');
    $transportOptions = ['data'=>$transports, 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'transport_id')->widget(Select2::className(), $transportOptions) ?>
	
    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'limit')->textInput(['maxlength' => true]) ?>

    <?php
    $selectOptions = ['data'=>TransportPrice::statusLabels(), 'pluginOptions'=>['allowClear'=>true], 'options'=>['prompt'=>'--Choose One--']];
    ?>
    <?= $form->field($model, 'status')->widget(Select2::className(), $selectOptions) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
