<?php

use app\helpers\DetailViewHelper;
use app\models\Transport;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Transport */
?>
<div class="transport-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            [
                'attribute' => 'status',
                'value' => $model->getStatusWithStyle(),
                'format'=>'raw',
            ],
            'created_at',
            'updated_at',
            DetailViewHelper::author($model, 'created_by'),
			DetailViewHelper::author($model, 'updated_by'),
        ],
    ]) ?>
	
	<?= yii\grid\GridView::widget([
		'id' => 'transport-price-grid',
		'dataProvider' => new yii\data\ArrayDataProvider([
			'allModels' => $model->transportPrices,
		]),
		'options' => ['class'=>'table-responsive'],
		'columns' => [
			'code',
			[
				'label' => 'First Hour',
				'attribute' => 'amount_1',
				'content' => function ($model) {
					return $model->getFormattedAmount(1);
				},
			],
			[
				'label' => 'Second Hours',
				'attribute' => 'amount_2',
				'content' => function ($model) {
					return $model->getFormattedAmount(2);
				},
			],
			[
				'label' => 'Third Hours',
				'attribute' => 'amount_3',
				'content' => function ($model) {
					return $model->getFormattedAmount(3);
				},
			],
            [
				'label' => 'Max Amount',
				'attribute' => 'amount',
				'content' => function ($model) {
					return $model->getFormattedAmount();
				},
			],
            [
				'label' => 'Limit (Within Days',
				'attribute' => 'limit',
				'value' => 'limit',
			],
		],
	]) ?>

</div>
