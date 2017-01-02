<?php

use app\helpers\FormatConverter;
use app\models\Setting;
use app\models\Transaction;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model Transaction */

?>
<div class="text-center">
	<span><?= $model->vehicle ? $model->vehicle->name  . ' /' : '' ?> <?= $model->code ?></span>
	<br/>
	<span><?= $model->getFormattedIndoDateTime() ?></span>
	<br/>
	<span><?= Setting::getCompanyName() ?> - <?= $model->createdBy ? $model->createdBy->getIdentityName() : ''; ?></span>
	<?= $model->getShowBarcodeHtml() ?>
	---------------------------------------
</div>
<div class="text-center">
	<small><?= Setting::getStructEntryFooter() ?></small>
</div>
<?= Html::beginForm(Url::to(['transaction/create']), 'get') ?>
<?= Html::submitButton('Print / Press Enter', ['class'=>'print', 'id'=>'buttonPrint', 'onclick'=>'printWindow()']) ?>
<?= Html::endForm() ?>