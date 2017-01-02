<?php

use app\models\Transaction;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Transaction */

if ($model->scenario == Transaction::SCENARIO_ENTRY) {
	$title = 'Buat Transaksi Masuk';
	$form = '_form-entry';
} else {
	$title = 'Buat Transaksi Keluar';
	$form = '_form-exit';
}

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

	<div class="panel panel-success">
		<div class="panel-heading">
			<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">
			<?= $this->render($form, [
				'model' => $model,
			]) ?>
		</div>
		
	</div>

</div>
