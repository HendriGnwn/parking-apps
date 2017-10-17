<?php

$this->title = 'Laporan Transaksi Harian';

?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?= $this->title ?></h3>
	</div>
	<div class="panel-body">
        <div class="row only-print-disable">
            <div class="col-md-6">
                <?= yii\helpers\Html::beginForm(['report/transaction-daily'], 'get') ?>
                <div class="form-group">
                    <label for="date">Tanggal:</label>
                    <?= \yii\jui\DatePicker::widget([
                        'name' => 'date', 
                        'value' => Yii::$app->request->get('date', ''), 
                        'options' => [
                            'placeholder' => 'Select date', 
                            'class' => 'form-control',
                            'id' => 'date'
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= yii\helpers\Html::submitInput('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
                <?= yii\helpers\Html::endForm() ?>
            </div>
            <div class="col-md-6 text-right">
                <?= yii\helpers\Html::a("Print", ['report/transaction-daily-print', 'date' => Yii::$app->request->get('date', '')], ['class' => 'btn btn-primary']) ?><br/><br/>
            </div>
        </div>
        
		<?= $this->render('_list-transaction-daily', []) ?>
	</div>
</div>