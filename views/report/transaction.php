<?php

use app\models\TransportPrice;
use app\models\User;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Laporan Transaksi';

CrudAsset::register($this);

$listUsers = ArrayHelper::map(User::listActiveUser(), 'id', 'username');

?>
<div id="report-transaction">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'toolbar'=> [
			['content'=>
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
				['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
				'{toggleData}'.
				'{export}'
			],
		],          
		'striped' => true,
		'pjax' => true,
		'condensed' => true,
		'responsive' => true,          
		'showFooter' => true,
		'panel' => [
			'type' => 'primary', 
			'heading' => '<i class="glyphicon glyphicon-list"></i> '.$this->title,
			'before' => $this->render('_search-transaction', ['model'=>$searchModel]),
		],
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			[
				'attribute'=>'code',
				'value'=>'code',
				'options' => [
					'style' => 'width:10%',
				],
			],
			[
				'attribute'=>'police_number',
				'value'=>'police_number',
				'options' => [
					'style' => 'width:8%',
				],
			],
			[
				'attribute' => 'time_in',
				'label' => 'Waktu',
				'content' => function ($model) {
					$timeIn = $model->time_in;
					$timeOut = $model->time_out;
					$html = '<b>M: </b>'.$timeIn.'<br/>';
					$html.= '<b>K: </b>'.$timeOut;
					return $html;
				},
				'options' => [
					'style' => 'width:20%',
				]
			],
			[
				'attribute'=>'transport_price_id',
				'label'=>'Kendaraan',
				'filter'=>ArrayHelper::map(TransportPrice::find()->active()->all(), 'id', 'transportWithCode'),
				'content'=>function($model){
					return $model->transportPrice ? $model->transportPrice->transportWithCode : $model->transport_price_id;
				},
				'options' => [
					'style' => 'width:15%',
				],
			],
			[
				'attribute'=>'created_at',
				'value'=>'created_at',
				'options' => [
					'style' => 'width:8%',
				],
			],
			[
				'attribute'=>'updated_at',
				'value'=>'updated_at',
				'options' => [
					'style' => 'width:8%',
				],
			],
			[
				'attribute'=>'created_by',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $listUsers,
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'--Choose One--'],
				'content'=>function($model){
					return $model->createdBy ? $model->createdBy->username : $model->created_by;
				},
				'options' => [
					'style' => 'width:5%',
				],
			],
			[
				'attribute'=>'updated_by',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $listUsers,
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>'--Choose One--'],
				'content'=>function($model){
					return $model->updatedBy ? $model->updatedBy->username : $model->updated_by;
				},
				'footer' => 'Total Keseluruhan',
				'options' => [
					'style' => 'width:5%',
				],
			],
			[
				'attribute' => 'final_amount',
				'label' => 'Total',
				'content' => function ($model) {
					return $model->getFormattedFinalAmount();
				},
				'footer' => $searchModel->getTotalAmount($dataProvider),
			],
		],
	]); ?>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>