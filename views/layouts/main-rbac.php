<?php

/* @var $this View */
/* @var $content string */

use app\assets\AppAsset;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title . ' - ' . Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    
	<?= $this->render('_menu.php') ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
		
		<?= Nav::widget([
			'options' => ['class' => 'nav nav-tabs'],
			'items' => [
				['label'=>'Assignments', 'url'=>['/admin/assignment/index']],
				['label'=>'Permissions', 'url'=>['/admin/permission/index']],
				['label'=>'Roles', 'url'=>['/admin/role/index']],
				['label'=>'Rules', 'url'=>['/admin/rule/index']],
				['label'=>'Routes', 'url'=>['/admin/route/index']],
				['label'=>'Menus', 'url'=>['/admin/menu/index']],
			],
		]) ?>
		
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
