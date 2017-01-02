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
$this->title = 'Laporan Rekapitulasi Transaksi';

CrudAsset::register($this);

$listUsers = ArrayHelper::map(User::listActiveUser(), 'id', 'username');

?>
<div id="report-transaction">
	<?php //var_dump($dataProvider->models); die; ?>
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
				'attribute'=>'date',
				'value'=>'date',
				'footer'=>'Total',
			],
			[
				'attribute'=>'motocycle',
				'footer' => $searchModel->getTotalField($dataProvider, 'motocycle'),
			],
			[
				'attribute'=>'car',
				'footer' => $searchModel->getTotalField($dataProvider, 'car'),
			],
			[
				'attribute'=>'big_car',
				'footer' => $searchModel->getTotalField($dataProvider, 'big_car'),
			],
			[
				'attribute'=>'voucher_id',
				'footer' => $searchModel->getTotalField($dataProvider, 'voucher_id'),
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
				'attribute' => 'final_amount',
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