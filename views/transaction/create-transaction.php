<?php

use app\models\Transaction;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Transaction */

$this->title = 'Create Transaction';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

	<div class="panel panel-success">
		<div class="panel-heading">
			<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">
			<?= $this->render('_form-create-transaction', [
				'model' => $model,
			]) ?>
		</div>
		
	</div>

</div>
