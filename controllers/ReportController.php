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
	
	public function actionTransactionMonthly()
	{
		return $this->render('transaction-monthly', []);
	}
	
	public function actionTransactionMonthlyPrint()
    {
		$this->layout = 'report-print';
        return $this->render('print-transaction-monthly', []);
    }
	
	public function actionTransactionPerGate()
	{
		
	}
	
	public function actionTransactionMonthlyRecapitulation()
	{
		return $this->render('transaction-monthly-recapitulation', []);
	}
	
	public function actionTransactionMonthlyRecapitulationPrint()
	{
		$this->layout = 'report-print';
		return $this->render('print-transaction-monthly-recapitulation', []);
	}
	
	public function actionTransactionDaily()
	{
		return $this->render('transaction-daily', []);
	}
    
    public function actionTransactionDailyPrint()
    {
		$this->layout = 'report-print';
        return $this->render('print-transaction-daily', []);
    }
}
