<?php

use app\helpers\DetailViewHelper;
use app\models\Gate;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Gate */
?>
<div class="gate-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
				'attribute'=>'gate_type',
				'value'=>$model->getGateType(),
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
