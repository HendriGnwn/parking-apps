<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicle */
?>
<div class="vehicle-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
