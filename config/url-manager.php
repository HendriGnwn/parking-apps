<?php

return [
	'class' => 'yii\web\UrlManager',
	'showScriptName' => false,
	'enablePrettyUrl' => true,
	'rules' => [
		
		'transaction/print-in/<id:\d+>' => 'transaction/print-in',
		'transaction/print-out/<id:\d+>' => 'transaction/print-out',
		
		'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
		'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
		'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
		
		'<controller:\w+>/<id:\d+>' => '<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
	],
];