<?php

use dmstr\widgets\Menu;
use mdm\admin\components\MenuHelper;
use yii\helpers\ArrayHelper;
?>
<aside class="main-sidebar">
    <section class="sidebar">
		<?php
		$callback = function($menu){
			$data = eval($menu['data']);
			$result = [
				'label' => $menu['name'], 
				'url' => [$menu['route']],
				'items' => $menu['children']
			];
			
			if($data !== false){ $result	+= $data; }
			
			return $result;
		};
		
		$mainMenu	= ['label' => 'Main Menu', 'options' => ['class' => 'header']];
		$menuItems	= MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
		$rbcMenu	= ['label' => 'Rigths', 'icon' => 'fa fa-gears', 'url' => ['/admin'], 'visible' => !Yii::$app->user->isGuest];
		$menuItems	= ArrayHelper::merge([$mainMenu], $menuItems);
		$menuItems	= ArrayHelper::merge($menuItems, [$rbcMenu]);

		echo Menu::widget([
			'options' => ['class' => 'sidebar-menu'],
			'items' => $menuItems,
		]);
		?>

    </section>

</aside>
