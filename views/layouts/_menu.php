<?php

use app\models\Setting;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;


NavBar::begin([
	'brandLabel' => Setting::getAppName(),
	'brandUrl' => Yii::$app->homeUrl,
	'options' => [
		'class' => 'navbar-inverse navbar-fixed-top',
	],
]);
	
	$callback = function($menu) {
		$data = eval($menu['data']);
		$result = [
			'label' => $menu['name'], 
			'url' => [$menu['route']],
			'items' => $menu['children']
		];

		if($data !== false){ $result	+= $data; }

		return $result;
	};

	$menuItems	= MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
	$rbcMenu	= ['label' => 'Rights', 'icon' => 'fa fa-gears', 'url' => ['/admin/assignment/index'], 'visible' => Yii::$app->user->can('superadmin')];
	$menuItems	= ArrayHelper::merge($menuItems, [$rbcMenu]);
	$logins = [
		'label' => '<i class="fa fa-user"></i>',
		'encode' => false,
		'url' => '#',
		'items' => [
			['label' => 'Profile', 'url' => ['/user/settings']],
			['label' => 'Sign Out', 'url' => ['/user/security/logout'], 'linkOptions'=>['data-method'=>'post']],
		],
	];
	
	$menuItems	= ArrayHelper::merge($menuItems, [$logins]);
		
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => $menuItems,
    ]);
	
NavBar::end();
 
