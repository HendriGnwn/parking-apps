<?php

use app\models\User;
use dektrium\user\controllers\AdminController;
use dektrium\user\controllers\SecurityController;
use dektrium\user\Module;
use mdm\admin\models\Assignment;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'secure-parking',
	'name' => 'Secure Parking',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	
	// default language to use for i18n purpose
    // source translation is located in @app/messages directory
    'language' => 'id-ID',
	
	'timeZone' => 'Asia/Jakarta',
	
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ifLIpUPGJ7XcUCImJMfC1zRaE8erC1-O',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => require(__DIR__ . '/mail.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'i18n' => [
            'translations' => [
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages'
                ],
            ],
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
		'assetManager' => [
			'bundles' => [
				'dmstr\web\AdminLteAsset' => [
					'skin' => 'skin-blue',
				],
			],
		],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => require(__DIR__ . '/url-manager.php'),
		'view' => [
			'theme' => [
				'pathMap' => [
					//'@app/views' => '@app/themes/adminlte/views',
					'@dektrium/user/views' => '@app/themes/adminlte/views'
				],
				'baseUrl' => '@app/themes/adminlte',
			],
		],
		
	],
	'modules' => [
		'user' => [
			'class' => Module::className(),
			'admins' => ['admin', 'owner'],
            'controllerMap' => [
                'admin' => [
					'class' => AdminController::className(),
					'on ' . AdminController::EVENT_AFTER_PROFILE_UPDATE => function ($e) {
						$post = Yii::$app->request->post();
						$params = [
							'gate_id' => $post['User']['gate_id'],
							'shift_id' => $post['User']['shift_id'],
						];
						$id = Yii::$app->request->get('id');
						(new User())->afterUpdateProfile($id, $params);
					},
					'on ' . AdminController::EVENT_AFTER_CREATE => function ($e) {
						$items = [['operator']];
						$model = new Assignment($e->user->id);
						$model->assign($items);
					},
					//'layout' => '@app/themes/adminlte/views/layouts/main',
                ],
                'security' => [
					'class' => SecurityController::className(),
					'on ' . SecurityController::EVENT_AFTER_LOGIN => function ($e) {
						(new User())->afterLogin($e->form->login);
					},
					'on ' . SecurityController::EVENT_AFTER_LOGOUT => function ($e) {
						(new User())->afterLogout($e->user->id);
					},
					'layout' => '@app/views/layouts/main-login',
                ],
                'settings' => [
					'class' => 'app\controllers\SettingsController',
					'layout' => '@app/views/layouts/main',
                ],
//                'registration' => [
//					'class' => dektrium\user\controllers\RegistrationController::className(),
//					'layout' => '@app/views/layouts/main-login',
//                ],
//                'recovery' => [
//					'class' => dektrium\user\controllers\RecoveryController::className(),
//					//'layout' => '@app/themes/adminlte/views/layouts/main',
//                ],
            ],
		],
		'admin' => [
			'class' => 'mdm\admin\Module',
			'layout' => '@app/views/layouts/main-rbac',
		],
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		],
	],
	'as access' => [
		'class' => 'mdm\admin\components\AccessControl',
		'allowActions' => [
			'site/login',
			'api*',
			'site/error',
			'user/security/logout',
			'user/logout',
		],
	],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
