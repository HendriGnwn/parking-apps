<?php
use yii\helpers\Html;
use app\components\widgets\HelloWidget;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'.Html::img('@web/images/mini-logo-thumb.png').'</span><span class="logo-lg">' . Html::img('@web/images/logo-thumb.png') . '</span>',Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="container-fluid">
			<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=(!Yii::$app->user->isGuest) ? Yii::$app->user->identity->username:'&nbsp;';?> <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><?=Html::a('Profile',['/user/settings/account']);?></li>
					<li><?= Html::a(
								'Sign out',
								['/site/logout'],
								['data-method' => 'post']
							) ?></li>
				  </ul>
				</li>
			  </ul>
            </div>
        </div>
    </nav>
</header>
