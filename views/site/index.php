<?php

use app\widgets\TransactionCountWidget;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */

$this->title = 'Dashboard';
?>
<div class="site-index">

    <div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><i class="fa fa-dashboard"></i>&nbsp;&nbsp;<?= Html::encode($this->title) ?></h1>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<?=	TransactionCountWidget::widget() ?>
				</div>
				<div class="col-sm-6 col-md-6">
					<?=	TransactionCountWidget::widget(['isToday'=>false]) ?>
				</div>
			</div>
		</div>
	</div>

</div>
