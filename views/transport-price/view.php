<?php

use app\helpers\DetailViewHelper;
use app\models\TransportPrice;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model TransportPrice */
?>
<div class="transport-price-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'transport_id',
            'code',
            'name',
            [
				'attribute' => 'amount_1',
				'value' => $model->getFormattedAmount(1),
			],
            [
				'attribute' => 'amount_2',
				'value' => $model->getFormattedAmount(2),
			],
            [
				'attribute' => 'amount_3',
				'value' => $model->getFormattedAmount(3),
			],
            [
				'attribute' => 'amount',
				'value' => $model->getFormattedAmount(),
			],
            'limit',
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

</div>
