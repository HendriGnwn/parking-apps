<?php

use app\helpers\FormatConverter;
use app\models\Setting;
use app\models\Transaction;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model Transaction */


?>

<div class="text-center">
	<span><?= $model->gateOut ? $model->gateOut->name . ' /' : '' ?> <?= $model->code ?></span>
	<br/>
	<span><?= $model->vehicle ? $model->vehicle->name . ' /' : '' ?> <?= $model->police_number ?></span>
	<br/>
	<span>Masuk: <?= $model->getFormattedIndoDateTime() ?></span>
	
	<?php if ($model->status == Transaction::STATUS_EXIT) { ?>
		<br/>
		<span>Keluar: <?= $model->getFormattedIndoDateTime('time_out') ?></span>
		<br/>
		<span>Lama Parkir: <?= $model->getDiffTimeInOut() ?></span>
	<?php } ?>
	<br/>
	<strong style="font-size:11pt">Total: <?= $model->getFinalAmountLabel() ?></strong>
	<br/>
	<strong><?= $model->getExitDescription() ?></strong>
	<span><?= Setting::getCompanyName() ?> - <?= $model->updatedBy ? $model->updatedBy->getIdentityName() : ''; ?></span>
	<br/>
	---------------------------------------
</div>
<div class="text-center">
	<small><?= Setting::getStructExitFooter() ?></small>
</div>
<?= Html::beginForm(Url::previous(), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>