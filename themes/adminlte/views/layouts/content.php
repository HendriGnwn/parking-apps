<?php
use dmstr\widgets\Alert;
use yii\bootstrap\Html;
use yii\helpers\Html as Html2;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;

$breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo Html2::encode($this->title);
                } else {
                    echo Inflector::camel2words(
                        Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
		[
			'tag' => 'ol',
			'encodeLabels' => false,
			'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Home', 'url' => ['/home/index']],
			'links' => $breadcrumbs,
		]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
		<?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <?=Yii::$app->params['version'];?>
    </div>
    <strong>Copyright &copy; <?=date('Y')?> <?=Html::a(Yii::$app->name, Yii::$app->homeUrl)?>.</strong> All rights reserved.
</footer>