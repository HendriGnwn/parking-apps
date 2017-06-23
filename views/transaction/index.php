<?php

use app\models\search\TransactionSearch;
use app\models\Transaction;
use app\models\TransportPrice;
use app\models\User;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this View */
/* @var $searchModel TransactionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Daftar Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">
		<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
		<p>
			<?= Html::a('<i class="fa fa-sign-in"></i>&nbsp;&nbsp;Buat Transaksi', ['create-transaction'], ['class' => 'btn btn-success']) ?>
			<?php //<?= Html::a('<i class="fa fa-sign-out"></i>&nbsp;&nbsp;Buat Transaksi Keluar', ['create-out'], ['class' => 'btn btn-primary']) ?>
		</p>
		<?php Pjax::begin(); ?>    
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'options' => [
				'class'=>'table-responsive',
			],
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				'code',
				'police_number',
				//'gate_in_id',
				'time_in',
				// 'gate_out_id',
				'time_out',
				// 'picture',
				[
					'attribute'=>'status',
					'filter'=>Transaction::statusLabels(),
					'content'=>function($model){
						return $model->getStatusWithStyle();
					}
				],
				//'payment_status',
				[
					'attribute'=>'transport_price_id',
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>ArrayHelper::map(TransportPrice::find()->active()->all(), 'id', 'transportWithCode'),
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'--Choose One--'],
					'content'=>function($model){
						return $model->transportPrice ? $model->transportPrice->transportWithCode : $model->transport_price_id;
					}
				],
				// 'payment_id',
				// 'voucher_id',
				// 'final_amount',
				'created_at',
				// 'updated_at',
				[
					'attribute'=>'created_by',
					'filterType'=>GridView::FILTER_SELECT2,
					'filter' => ArrayHelper::map(User::listActiveUser(), 'id', 'username'),
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'--Choose One--'],
					'content'=>function($model){
						return $model->createdBy ? $model->createdBy->username : $model->created_by;
					}
				],
				// 'updated_by',

				['class' => 'yii\grid\ActionColumn'],
			],
		]); ?>
		<?php Pjax::end(); ?>
	</div>
		</div>
</div>