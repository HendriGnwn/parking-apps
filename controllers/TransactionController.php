<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\search\TransactionSearch;
use app\models\Transaction;
use app\models\TransportPrice;
use app\models\Voucher;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends BaseController
{
	
	public function actionTest($id) {
		$transaction = Transaction::findOne($id);
		$transaction->printVehicleExit();
	}
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		//return $this->redirect(['create-transaction']);
		$session = Yii::$app->session;
		
        $model = new Transaction();
		$model->scenario = Transaction::SCENARIO_ENTRY;
		
		/** if session transactionGateIn found, set model gate_in_id */
		if ($session->has('transactionGateIn')) {
			$model->gate_in_id = $session->get('transactionGateIn');
		}
		
		/** if session transactionGateIn found, set model gate_in_id */
		if ($session->has('transactionTransportPriceId')) {
			$model->transport_price_id = $session->get('transactionTransportPriceId');
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$session->set('transactionGateIn', $model->gate_in_id);
			$session->set('transactionTransportPriceId', $model->transport_price_id);
            return $this->redirect(['print-in', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionPosPrintIn($id)
	{
		$model = $this->findModel($id);
		$model->printVehicleEntry();
		return $this->redirect(['view', 'id'=>$id]);
	}
	
	public function actionPosPrintOut($id)
	{
		$model = $this->findModel($id);
		$model->printVehicleExit();
		return $this->redirect(['view', 'id'=>$id]);
	}
	
	public function actionPrintIn($id)
	{
		$this->layout = 'print';
		
		$model = $this->findModel($id);
		return $this->render('print-in', [
			'model'=>$model
		]);
	}
	
	public function actionPrintOut($id)
	{
		$this->layout = 'print';
		
		$model = $this->findModel($id);
		return $this->render('print-out', [
			'model'=>$model
		]);
	}
	
	public function actionCreateOut()
	{
		//return $this->redirect(['create-transaction']);
		$session = Yii::$app->session;
		
		$model = new Transaction();
		$model->scenario = Transaction::SCENARIO_EXIT;
		
		/** if session transactionGateOut found, set model gate_out_id */
		if ($session->has('transactionGateOut')) {
			$model->gate_out_id = $session->get('transactionGateOut');
		}
		/** if session transactionPayment found, set model payment_id */
		if ($session->has('transactionPayment')) {
			$model->payment_id = $session->get('transactionPayment');
		}

        if ($model->load(Yii::$app->request->post())) {
			$model->attributes = Yii::$app->request->post('Transaction');
			$query = Transaction::getDataByCode($model->code);
			if (!$query) {
				return $this->redirect(['create-out']);
			}
			$query->scenario = Transaction::SCENARIO_EXIT;
			$query->code = $model->code;
			$query->police_number = $model->police_number;
			$query->time_out = $model->time_out;
			$query->gate_out_id = $model->gate_out_id;
			$query->transport_price_id = $model->transport_price_id;
			$query->payment_id = $model->payment_id;
			$query->voucher_id = $model->voucher_id;
			$query->final_amount = $model->final_amount;
			
			$session->set('transactionGateOut', $query->gate_out_id);
			$session->set('transactionPayment', $query->payment_id);
			
			if($query->validate()) {
				$query->save();
				//return $this->redirect(['print-out', 'id' => $query->id]);
				$query->printVehicleExit();
				return $this->redirect(['create-out']);
			} else {
				return $this->render('create', [
                'model' => $query,
            ]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
	}
	
	public function actionCreateManualInput()
	{
		//return $this->redirect(['create-transaction']);
		$session = Yii::$app->session;
		
		$model = new Transaction();
		$model->scenario = Transaction::SCENARIO_MANUAL_INPUT;
		
		/** if session transactionGateOut found, set model gate_out_id */
		if ($session->has('transactionGateOut')) {
			$model->gate_out_id = $session->get('transactionGateOut');
		}
		/** if session transactionPayment found, set model payment_id */
		if ($session->has('transactionPayment')) {
			$model->payment_id = $session->get('transactionPayment');
		}

        if ($model->load(Yii::$app->request->post())) {
			$model->attributes = Yii::$app->request->post('Transaction');
			
			$query = Transaction::find()
				->andWhere([
					'code'=>$model->code, 
					'payment_status'=>Transaction::PAYMENT_STATUS_WAITING
				])
				->limit(1)
				->one();
			if (!$query) {
				return $this->redirect(['create-manual-input']);
			}
			$query->scenario = Transaction::SCENARIO_MANUAL_INPUT;
			$query->code = $model->code;
			$query->status = Transaction::STATUS_MANUAL_INPUT;
			$query->police_number = $model->police_number;
			$query->time_out = $model->time_out;
			$query->gate_out_id = $model->gate_out_id;
			$query->transport_price_id = $model->transport_price_id;
			$query->payment_id = $model->payment_id;
			$query->voucher_id = $model->voucher_id;
			$query->final_amount = $model->final_amount;
			
			$session->set('transactionGateOut', $query->gate_out_id);
			$session->set('transactionPayment', $query->payment_id);
			
			if($query->validate()) {
				$query->save();
				$query->printVehicleExit();
				return $this->redirect(['create-manual-input']);
			} else {
				return $this->render('create', [
                'model' => $query,
            ]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
	}
	
	public function actionCreateTransaction()
	{
		$session = Yii::$app->session;
		
		$model = new Transaction();
		$model->scenario = Transaction::SCENARIO_ENTRY_AND_EXIT;
		
		/** if session transactionGateIn found, set model gate_in_id */
		if ($session->has('transactionGateIn')) {
			$model->gate_in_id = $session->get('transactionGateIn');
		}
		
		/** if session transactionGateIn found, set model gate_in_id */
		if ($session->has('transactionPayment')) {
			$model->payment_id = $session->get('transactionPayment');
		}

        if ($model->load(Yii::$app->request->post()) && ($model->save())) {
			
			$session->set('transactionGateIn', $model->gate_in_id);
			$session->set('transactionTransportPriceId', $model->transport_price_id);
			$session->set('transactionPayment', $model->payment_id);
			//return $this->redirect(['print-out', 'id' => $model->id]);
			$model->printVehicleExit();
			return $this->redirect(['create-transaction']);
			
        } else {
			render:
            return $this->render('create-transaction', [
				'model' => $model
			]);
        }
	}
	
	/**
	 * call ajax request to get data transaction by code and police number
	 * 
	 * @return json_encode
	 */
	public function actionAjaxCalculateByCodeAndPoliceNumber()
	{
		$request = Yii::$app->request;
		if(!$request->isAjax) {
			return null;
		}
		if ($request->post('transportPrice') && $request->post('code')) {
			$transaction = Transaction::find()->where(['code'=>$request->post('code')])->one();
			$transaction->setScenario(Transaction::SCENARIO_PREPARE_DATA_BEFORE_EXIT);
			$transaction->transport_price_id = $request->post('transportPrice');
			$transaction->save();
		}
		
		$params = [
			'code' => $request->post('code'),
			'policeNumber' => $request->post('policeNumber'),
			'transportPrice' => $request->post('transportPrice'),
			'timeOut' => $request->post('timeOut'),
		];
		$query = (new Transaction())->calculateByParams($params);
		if(!$query) {
			return null;
		}
		
		echo json_encode($query);
	}
	
	public function actionAjaxCalculateTotalByTransportPrice()
	{
		$request = Yii::$app->request;
		if (!$request->isAjax) {
			return null;
		}
		
		$transportPriceId = $request->post('transport_price');
		$transportPrice = TransportPrice::find()->where(['id' => $transportPriceId])->one();
		if (!$transportPrice) {
			return null;
		}
		
		$arrayFinalAmount = ['voucher_id' => null,'final_amount' => $transportPrice->amount, 'transport_price_id'=>$transportPriceId];
		$result = ArrayHelper::merge($transportPrice->attributes, $arrayFinalAmount);

		$vehicleRelation = ['vehicle' => $transportPrice->vehicle->attributes];
		$result = ArrayHelper::merge($result, $vehicleRelation);
		
		return json_encode($result);
	}
	
	/**
	 * call ajax request to get data transaction by time in and police number
	 * 
	 * @return json_encode
	 */
	public function actionAjaxCalculateByTimeInAndTimeOut()
	{
		$request = Yii::$app->request;
		if(!$request->isAjax) {
			return null;
		}
		
		$code = $request->post('code');
		
		if ($code == null) {
			$transaction = new Transaction();
			$transaction->setScenario(Transaction::SCENARIO_ENTRY);
			$transaction->setAttributes([
				'gate_in_id' => 0,
				'time_in' => $request->post('timeIn'),
				'transport_price_id' => $request->post('transportPrice'),
			]);
			$transaction->save();
			
			$code = $transaction->code;
		}
		
		$params = [
			'code' => $code,
			'policeNumber' => $request->post('policeNumber'),
			'timeOut' => $request->post('timeOut'),
		];
		$query = (new Transaction())->calculateByParams($params);
		if(!$query) {
			return null;
		}
		
		echo json_encode($query);
	}
}