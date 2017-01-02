<?php

use app\models\Transport;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
		'content'=>function($model) {
			return $model->getStatusWithStyle();
		},
		'filter'=>Transport::statusLabels(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_at',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'created_by',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'updated_by',
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
		'template' => '{view} {update}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        //'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
//                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                          'data-request-method'=>'post',
//                          'data-toggle'=>'tooltip',
//                          'data-confirm-title'=>'Are you sure?',
//                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   