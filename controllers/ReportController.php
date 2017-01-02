<?php

namespace app\controllers;

use app\models\search\TransactionSearch;
use app\models\search\VoucherSearch;
use app\models\User;
use Yii;

class ReportController extends BaseController
{
    public function actionIndex()
    {
        return $this->redirect(['transaction']);
    }
	
	public function actionTransaction()
	{
		$searchModel = new TransactionSearch();
        $dataProvider = $searchModel->reportSearch(Yii::$app->request->queryParams);

        return $this->render('transaction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	public function actionTransactionToday()
	{
		$this->layout = 'print';
		$searchModel = new TransactionSearch();
		$dataProvider = $searchModel->searchToday(Yii::$app->request->queryParams);
		$user = User::findOne(Yii::$app->user->id);

		return $this->render('transaction-today', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'user' => $user,
        ]);
	}
	
	public function actionVoucher()
	{
		$searchModel = new VoucherSearch();
		$dataProvider = $searchModel->reportSearch(Yii::$app->request->queryParams);
		
		return $this->render('voucher', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	public function actionTransactionRecapitulation()
	{
		$searchModel = new TransactionSearch();
		$dataProvider = $searchModel->reportRecapitulation(Yii::$app->request->queryParams);
		
		return $this->render('transaction-recapitulation', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}
}
