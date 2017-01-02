<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;

use app\helpers\FormatConverter;
use app\models\Transaction;
use app\models\Vehicle;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Description of TransactionCountWidget
 *
 * @author Hendri <hendri.gnw@gmail.com>
 */
class TransactionCountWidget extends Widget 
{
	public $isToday = true;
	
	public function run()
	{
		return $this->render('transaction-count', [
			'data' => $this->getData(),
			'title' => $this->getTitle(),
		]);
	}
	
	public function getTitle() 
	{
		if($this->isToday) {
			return 'Transaksi Hari ini <small>' . FormatConverter::formatIndoDate(date('Y-m-d'), "%d %B %Y") . '</small>';
		}
		return 'Semua Transaksi';
	}
	
	private function getData()
	{
		$vehicles = Vehicle::find()->active()->all();
		
		$result = [];
		foreach($vehicles as $vehicle)
		{
			$today = $this->isToday ? ["DATE_FORMAT(time_in, '%Y-%m-%d')"=>date('Y-m-d')] : [];
			
			$params = ArrayHelper::merge(['vehicle_id'=>$vehicle->id], $today);
			
			$countTransaction = Transaction::findByRole()->andWhere($params)->count();
			$countTransactionIn = Transaction::findByRole()->andWhere($params)->andWhere(['status'=>Transaction::STATUS_ENTRY])->count();
			$countTransactionOut = Transaction::findByRole()->andWhere($params)->andWhere(['status'=>Transaction::STATUS_EXIT])->count();
			
			$result[$vehicle->name] = ['all'=>$countTransaction, 'in'=>$countTransactionIn, 'out'=>$countTransactionOut];
		}
		
		return $result;
	}
}
