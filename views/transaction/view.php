<?php

use app\helpers\DetailViewHelper;
use app\models\Transaction;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Transaction */

$this->title = 'Transaksi #' . $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">

			<p>
				<?= Html::a(Yii::t('app', 'Print Struk Masuk'), ['print-in', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
				<?= $model->status == Transaction::STATUS_EXIT ? Html::a(Yii::t('app', 'Print Struk Keluar'), ['print-out', 'id' => $model->id], ['class' => 'btn btn-success']) : '' ?>
				<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
				<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
						'method' => 'post',
					],
				]) ?>
			</p>

			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					'id',
					'code',
					'police_number',
					[
						'attribute'=>'gate_in_id',
						'value'=>$model->gateIn ? $model->gateIn->name : $model->gate_in_id,
					],
					'time_in',
					[
						'attribute'=>'gate_out_id',
						'value'=>$model->gateOut ? $model->gateOut->name : $model->gate_out_id,
					],
					'time_out',
					[
						'attribute'=>'camera_in',
						'value'=>$model->getCameraInImgHtml(),
						'format'=>'raw',
					],
					[
						'attribute'=>'camera_out',
						'value'=>$model->getCameraOutImgHtml(),
						'format'=>'raw',
					],
					[
						'attribute'=>'vehicle_id',
						'value'=>$model->vehicle ? $model->vehicle->name : $model->vehicle_id,
					],
					[
						'attribute'=>'transport_price_id',
						'value'=>$model->transportPrice ? $model->transportPrice->transportWithCode : $model->transport_price_id,
					],
					[
						'attribute'=>'payment_status',
						'value'=>$model->getPaymentStatusWithStyle(),
						'format'=>'raw',
					],
					[
						'attribute'=>'status',
						'value'=>$model->getStatusWithStyle(),
						'format'=>'raw',
					],
					[
						'attribute'=>'payment_id',
						'value'=>$model->payment ? $model->payment->name : $model->payment_id,
					],
					[
						'attribute'=>'voucher_id',
						'value'=>$model->voucher ? $model->voucher->code : $model->voucher_id,
					],
					'final_amount',
					'created_at',
					'updated_at',
					DetailViewHelper::author($model, 'created_by'),
					DetailViewHelper::author($model, 'updated_by'),
				],
			]) ?>
		</div>
	</div>
</div>
