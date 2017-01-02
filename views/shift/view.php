<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */
?>
<div class="shift-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'start_time',
            'end_time',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
