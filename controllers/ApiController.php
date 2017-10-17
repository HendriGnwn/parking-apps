<?php

namespace app\controllers;

use app\models\Setting;
use app\models\Transaction;
use Carbon\Carbon;
use Yii;
use app\helpers\FormatConverter;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller
{
	const ACCESS_TOKEN = 'SnVuZ2xlbGFuZCBJbmRvbmVzaWENCg==';
	
	public function actionCreateGateIn()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		$request = Yii::$app->request;
		if (!isset($request->getHeaders()['authorization'])) {
			Yii::$app->response->setStatusCode(403);
			Yii::$app->response->data = [
				'status' => 'error',
				'message' => 'forbidden'
			];
			
			return Yii::$app->response->send();
		}
		
		if ($request->getHeaders()['authorization'] != self::ACCESS_TOKEN) {
			Yii::$app->response->setStatusCode(403);
			Yii::$app->response->data = [
				'status' => 'error',
				'message' => 'forbidden'
			];
			
			return Yii::$app->response->send();
		}
		
		
		if (!$request->isPost) {
			Yii::$app->response->setStatusCode(405);
			Yii::$app->response->data = [
				'status' => 'error',
				'message' => 'Method not allowed'
			];
			
			return Yii::$app->response->send();
		}
		$model = new Transaction();
		$model->scenario = Transaction::SCENARIO_ENTRY;
        $model->attributes = $request->post();
        $model->time_in = Carbon::now()->toDateTimeString();
        $model->cameraFileUpload = UploadedFile::getInstanceByName('cameraFileUpload');
		if(!$model->validate()) {
			return [
				'status' => 'error',
				'message' => 'Validation errors',
				'validators' => $model->getErrors(),
			];
		}
		$model->save();
		
		return [
			'status' => 'success',
			'data' => [
				'app_name' => Setting::getAppName(),
				'company_address' => Setting::getCompanyAddress(),
				'company_phone' => Setting::getCompanyPhone(),
				'vehicle' => isset($model->vehicle) ? $model->vehicle->name : '',
				'code' => $model->code, // 17 digit alpha numeric
				'date' => FormatConverter::formatIndoDate($model->time_in, '%d %B %Y'),
				'time' => FormatConverter::formatIndoDate($model->time_in, '%H:%M:%S'),
				'time_original' => $model->time_in,
				'footer_description' => Setting::getStructEntryFooter(),
			],
		];
	}
}

