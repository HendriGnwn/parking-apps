<?php

use app\helpers\DetailViewHelper;
use app\models\Voucher;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Voucher */
?>
<div class="voucher-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute' => 'voucher_type',
				'value' => $model->getVoucherType(),
			],
            'code',
			[
				'attribute' => 'transport_price_id',
				'value' => $model->transportPrice ? $model->transportPrice->getTransportWithCode() : $model->transport_price_id,
			],
            'start_date',
            'end_date',
            'limit',
			[
				'attribute' => 'voucher_type_amount',
				'value' => $model->getVoucherTypeAmount(),
			],
            [
                'attribute' => 'amount',
                'value' => $model->getFormattedAmount(),
                'format'=>'raw',
            ],
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
