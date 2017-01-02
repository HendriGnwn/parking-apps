<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Transaction',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="transaction-update">

    <div class="transaction-create">

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
		
	</div>

</div>

</div>
