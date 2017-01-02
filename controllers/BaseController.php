<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * parent class of the Controller
 *
 * @author Hendri <hendri.gnw@gmail.com>
 */
class BaseController extends Controller
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
}
