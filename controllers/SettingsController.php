<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use dektrium\user\controllers\SettingsController as BaseSettingsController;
use yii\filters\AccessControl;

/**
 * Description of SettingsController
 *
 * @author Hendri <hendri.gnw@gmail.com>
 */
class SettingsController extends BaseSettingsController
{
	/**
     * @inheritdoc
     */
    public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	
	public function actionInformation()
	{
		return $this->render('information');
	}
}
