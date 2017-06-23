<?php

namespace app\models;

use app\helpers\DateTime;
use app\helpers\FormatConverter;
use app\models\query\TransactionQuery;
use barcode\barcode\BarcodeGenerator;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $code
 * @property string $police_number
 * @property integer $gate_in_id
 * @property string $time_in
 * @property integer $gate_out_id
 * @property string $time_out
 * @property string $picture
 * @property integer $status
 * @property integer $payment_status
 * @property integer $transport_price_id
 * @property integer $vehicle_id
 * @property integer $payment_id
 * @property integer $voucher_id
 * @property string $final_amount
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * 
 * @property TransportPrice[] $transportPrice
 * @property Vehicle[] $vehicle
 * @property Voucher[] $voucher
 * @property Payment[] $payment
 * @property Gate[] $gateIn
 * @property Gate[] $gateOut
 */
class Transaction extends BaseActiveRecord
{
	const SCENARIO_ENTRY = 'entry';
	const SCENARIO_EXIT = 'exit';
	const SCENARIO_ENTRY_AND_EXIT = 'entryAndExit';
	
	const CODE_PREFIX = '';
	
	const STATUS_ENTRY = 1;
	const STATUS_EXIT = 2;
	const STATUS_ENTRY_EXIT = 3;
	
	const PAYMENT_STATUS_DRAFT = 1;
	const PAYMENT_STATUS_WAITING = 5;
	const PAYMENT_STATUS_PAID = 10;
	
	const TIME_00 = '00:00:00';
	const TIME_24 = '23:59:59';
	
	public $motocycle;
	public $car;
	public $big_car;
	public $date;

	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['gate_in_id', 'time_in', 'transport_price_id'], 'required', 'on'=> [self::SCENARIO_ENTRY, self::SCENARIO_ENTRY_AND_EXIT]],
			[['police_number', 'code', 'gate_out_id', 'time_out', 'payment_id', 'final_amount'], 'required', 'on'=>self::SCENARIO_EXIT],
			[['police_number', 'payment_id', 'final_amount'], 'required', 'on'=>self::SCENARIO_ENTRY_AND_EXIT],
            [['gate_in_id', 'gate_out_id', 'status', 'payment_status', 'transport_price_id', 'payment_id', 'voucher_id', 'created_by', 'updated_by'], 'integer'],
            [['code', 'police_number', 'gate_in_id', 'time_in', 'gate_out_id', 'time_out', 'status', 
				'vehicle_id', 'payment_status', 'transport_price_id', 'payment_id', 'voucher_id', 'final_amount', 'created_at', 'updated_at', 'picture'], 'safe'],
            [['final_amount'], 'number'],
			[['payment_status'], 'default', 'value'=>self::PAYMENT_STATUS_DRAFT],
			[['status'], 'default', 'value'=>self::STATUS_ENTRY],
			['police_number', 'match', 'pattern'=>'/^([\w\S])+$/', 'message'=>"{attribute} jangan memakai spasi"],
            [['code', 'police_number'], 'string', 'max' => 100],
            [['picture'], 'string', 'max' => 200],
			[['time_out'], 'validateTime']
        ];
    }
	
	public function validateTime($attribute, $params)
	{
		if ($this->scenario != self::SCENARIO_ENTRY_AND_EXIT) {
			if ($this->time_out < $this->time_in) {
				$this->addError($this->time_out, 'Waktu keluar tidak boleh kurang dari Waktu Masuk.');
			}
		}
	}
	
	public function beforeSave($insert) 
	{
		if ($insert) {
			$this->code = $this->generateCode();
			$this->payment_status = self::PAYMENT_STATUS_WAITING;
			$transportPrice = TransportPrice::findOne($this->transport_price_id);
			$this->vehicle_id = $transportPrice ? $transportPrice->vehicle->id : null;
		}
		
		if ($this->scenario == self::SCENARIO_EXIT) {
			$this->payment_status = self::PAYMENT_STATUS_PAID;
			$this->status = self::STATUS_EXIT;
			
			$calculate = $this->calculateByParams();
			$this->final_amount = $calculate['final_amount'];
			$this->transport_price_id = $calculate['transport_price_id'];
			$this->voucher_id = $calculate['voucher_id'];
		}
		
		if ($this->scenario == self::SCENARIO_ENTRY_AND_EXIT) {
			$this->payment_status = self::PAYMENT_STATUS_PAID;
			$this->gate_out_id = null;
			$this->time_out = $this->time_in;
			$this->status = self::STATUS_ENTRY_EXIT;
		}
		
		return parent::beforeSave($insert);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kode',
            'police_number' => 'Nomor Polisi',
            'gate_in_id' => 'Pintu Masuk',
            'time_in' => 'Waktu',
            'gate_out_id' => 'Pintu Keluar',
            'time_out' => 'Waktu Keluar',
            'picture' => 'Gambar',
            'status' => 'Status',
            'payment_status' => 'Status Pembayaran',
			'vehicle_id' => 'Kendaraan',
            'transport_price_id' => 'Jenis - Jenis Kendaraan',
            'payment_id' => 'Pembayaran',
            'voucher_id' => 'Voucher',
            'final_amount' => 'Total Pembayaran',
            'created_at' => 'Dibuat di',
            'updated_at' => 'Diedit di',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Diedit oleh',
            'date' => 'Tanggal',
            'motocycle' => 'Motor',
            'car' => 'Mobil',
            'big_car' => 'Mobil Besar',
        ];
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
	
	/**
	 * find by role
	 * 
	 * @return Transaction
	 */
	public static function findByRole()
	{
		$user = Yii::$app->user;
		
		if($user->can('superadmin') || $user->can('owner')) {
			return Transaction::find();
		} else {
			return Transaction::find()->isOwnerCreated();
		}
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getPayment()
	{
		return $this->hasOne(Payment::className(), ['id' => 'payment_id'])->active();
	}	
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getTransportPrice()
	{
		return $this->hasOne(TransportPrice::className(), ['id' => 'transport_price_id'])->active();
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getGateIn()
	{
		return $this->hasOne(Gate::className(), ['id' => 'gate_in_id'])->active();
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getGateOut()
	{
		return $this->hasOne(Gate::className(), ['id' => 'gate_out_id'])->active();
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getVehicle()
	{
		return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id'])->active();
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getVoucher()
	{
		return $this->hasOne(Voucher::className(), ['id' => 'voucher_id'])->active();
	}	
	
	/**
	 * fields is datetime data type
	 * 
	 * @return array
	 */
	public static function filterDatetimes()
	{
		return [
			'time_in' => 'Masuk',
			'time_out' => 'Keluar',
			'created_at' => 'Dibuat di',
			'updated_at' => 'Diedit di',
		];
	}
	
	public static function statusLabels() {
        return [
            self::STATUS_ENTRY => 'Parkir',
            self::STATUS_EXIT => 'Sudah Keluar',
            self::STATUS_ENTRY_EXIT => 'Parkir - Keluar',
        ];
    }

    public function getStatusLabel() {
        return $this->statusLabels()[$this->status];
    }
	
	public function getStatusWithStyle() {
        switch($this->status) {
            case self::STATUS_ENTRY: return Html::label($this->getStatusLabel(), null, ['class'=>'label label-success']);
            case self::STATUS_EXIT: return Html::label($this->getStatusLabel(), null, ['class'=>'label label-danger']);
            case self::STATUS_ENTRY_EXIT: return Html::label($this->getStatusLabel(), null, ['class'=>'label label-primary']);
        }
    }
	
	public static function paymentStatusLabels() {
        return [
			self::PAYMENT_STATUS_DRAFT => 'Draft',
            self::PAYMENT_STATUS_WAITING => 'Menunggu',
            self::PAYMENT_STATUS_PAID => 'Dibayar',
        ];
    }
	
	public function getPaymentStatusLabel() {
        return $this->paymentStatusLabels()[$this->payment_status];
    }
	
	public function getPaymentStatusWithStyle() {
        switch($this->payment_status) {
            case self::PAYMENT_STATUS_DRAFT: return Html::label($this->getPaymentStatusLabel(), null, ['class'=>'label label-default']);
            case self::PAYMENT_STATUS_WAITING: return Html::label($this->getPaymentStatusLabel(), null, ['class'=>'label label-primary']);
			case self::PAYMENT_STATUS_PAID: return Html::label($this->getPaymentStatusLabel(), null, ['class'=>'label label-success']);
        }
    }
	
	/**
     * Generate order number in format `[prefix][Y][m][d][xxxxxx]` where:
     * [prefix] is characters that placed before generated number.
     * [Y] is current year in php date format.
     * [m] is current month in php date format.
     * [d] is current date in php date format.
     * [xxxxxx] is incremental number of order each day pad by certain length.
     *
     * ea:
     * - ...160521001
     * - ...160521002
     * - ...160521003
     * - ...160522001
     * - (...) is TransportPrice
     * @param string $prefix
     * @param integer $padLength increment pad length
     * @return string
     */
    public function generateCode($padLength = 3)
    {
		$prefix = self::CODE_PREFIX;
		
		$transportPriceCode = TransportPrice::getCodeById($this->transport_price_id);
		$prefix = $prefix . $transportPriceCode;
		
        $left = $prefix . date('ymd');
        $leftLen = strlen($left);
        $increment = 1;

        $last = self::find()
            ->select('code')
            ->where(['LIKE', 'code', $left])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->scalar();

        if ($last) {
            $increment = (int) substr($last, $leftLen, $padLength);
            $increment++;
        }

        $number = str_pad($increment, $padLength, '0', STR_PAD_LEFT);

        return $left . $number;
    }
	
	/**
	 * calculate by code and police number and time out
	 * with status is entry and payment status is waiting
	 * 
	 * @param type $params [] default is code, policeNumber, timeOut
	 * @return Transaction
	 */
	public function calculateByParams($params = ['code'=>null, 'policeNumber'=>null, 'timeOut'=>null])
	{
		$params['code'] = $params['code'] ? $params['code'] : $this->code;
		$params['policeNumber'] = $params['policeNumber'] ? $params['policeNumber'] : $this->police_number;
		$params['timeOut'] = $params['timeOut'] ? $params['timeOut'] : $this->time_out;
		
		$query = self::getDataByCode($params['code']);
		
		if(!$query) {
			return false;
		}
		
		$transportPriceId = $query->transport_price_id;
		$voucherId = $finalAmount = null;
		
		$voucher = Voucher::getActiveVoucherByCodeAndVehicle($params['policeNumber'], $query->vehicle_id);
		if($voucher) {
			$voucherId = $voucher->id;
			$transportPriceId = $voucher->transport_price_id;
			$finalAmount = $voucher->getVoucherAmount($query->final_amount);
		} else {
			$finalAmount = $query->calculateWithoutVoucher($params['timeOut']);
		}
		
		$arrayFinalAmount = ['voucher_id' => $voucherId,'final_amount' => $finalAmount, 'transport_price_id'=>$transportPriceId];
		$result = ArrayHelper::merge($query->attributes, $arrayFinalAmount);
		
		$vehicleRelation = ['vehicle' => $query->vehicle->attributes];
		$result = ArrayHelper::merge($result, $vehicleRelation);
		
		return $result;
	}
	
	/**
	 * calculate final amount without voucher
	 * 
	 * @param type $timeOut Y-m-d H:i:s, default is null (get time out in db)
	 * @return type
	 */
	public function calculateWithoutVoucher($timeOut = null)
	{
		$transportPrice = $this->transportPrice;
		
		$time_out = $timeOut ? $timeOut : $this->time_out;
		
		/** pisahkan date dengan time di variable yang berbeda */
		$dateIn = FormatConverter::formatDate($this->time_in, 'Y-m-d');
		$timeIn = FormatConverter::formatDate($this->time_in, 'H:i:s');
		$dateOut = FormatConverter::formatDate($time_out, 'Y-m-d');
		$timeOut = FormatConverter::formatDate($time_out, 'H:i:s');
		
		$finalAmount = 0;
		
		$getDay = DateTime::getDuration($dateIn, $dateOut)->days;
		/** jika rentan tanggal kurang dari 1 hari maka */
		if ($getDay < 1) {
			// selisih ketika kurang dari 1 hari
			$minuteDiff = ceil((strtotime($time_out) - strtotime($this->time_in)) / 60);
			$finalAmount += $this->getAmountByTimeDiff($minuteDiff);
			
			return $finalAmount;
		}
		
		/** kondisi ketika lebih dari 1 hari */
		$timeInDiff = ceil((strtotime(self::TIME_24) - strtotime($timeIn)) / 60);
		$timeOutDiff = ceil((strtotime($timeOut) - strtotime(self::TIME_00)) / 60);
		
		$amountTimeIn = $this->getAmountByTimeDiff($timeInDiff);
		$amountTimeOut = $this->getAmountByTimeDiff($timeOutDiff);
		
		/** set final amount di kelebihan hari dikurangi 1 */
		$finalAmount += ($transportPrice->amount * ($getDay - 1));
		/** set final amount dengan menambahkan amount time in dan amount time out */
		$finalAmount += ($amountTimeIn + $amountTimeOut);
		
		return $finalAmount;
	}
	
	/**
	 * mencari harga dengan kondisi perjam
	 * 
	 * @param type $time (dalam bentuk menit)
	 * @return type
	 */
	private function getAmountByTimeDiff($time)
	{
		$transportPrice = $this->transportPrice;
		
		$amount = 0;
		if ($time <= 60) {
			$amount += $transportPrice->amount_1;
		} else if ($time <= 120) {
			$amount += $transportPrice->amount_2;
		} else if ($time <= 180) {
			$amount += $transportPrice->amount_3;
		} else if ($time > 180) {
			$amount += $transportPrice->amount;
		}

		return $amount;
	}
	
	/**
	 * 
	 * @param type $code
	 * @return Transaction
	 */
	public static function getDataByCode($code)
	{
		$query = self::find()
			->andWhere([
				'code'=>$code, 
				'status'=>self::STATUS_ENTRY, 
				'payment_status'=>self::PAYMENT_STATUS_WAITING
			])
			->limit(1)
			->one();
				
		return $query;
	}
	
	/**
	 * generate barcode type code128
	 * 
	 * @return barcode
	 */
	private function generateBarcode()
	{
		$params = [
			'elementId' => 'barcode-transaction-code',
			'value' => $this->code,
			'type' => 'code93',
			'settings' => [
				'output' => 'bmp', /* css, bmp, svg, canvas */
				'bgColor' => '#FFFFFF', /* background color */
				'color' => '#000000', /* "1" Bars color */
				'barWidth' => 2,
				'barHeight' => 80,
				'moduleSize' => 5,
				'addQuietZone' => 0,
				'posX' => 10,
				'posY' => 20
			],
 		];
		
		return BarcodeGenerator::widget($params);
	}
	
	/**
	 * show barcode with html
	 * 
	 * @return string
	 */
	public function getShowBarcodeHtml()
	{
		$html  = Html::tag('div', '', ['class'=>'barcode-transaction-code', 'id'=>'barcode-transaction-code']);
		$html .= $this->generateBarcode();
		$html .= Html::tag('div', $this->code, ['class'=>'text-center barcode-text']);
		return $html;
	}
	
	/**
	 * get diff time in and time out within day hour minute
	 * 
	 * @return string
	 */
	public function getDiffTimeInOut()
	{
		$html = '';
		$duration = DateTime::getDuration($this->time_in, $this->time_out);
		
		if($duration->days > 0) {
			$html .= $duration->days . ' Hari ';
		}
		
		if($duration->h > 0) {
			$html .= $duration->h . ' Jam ';
		}
		
		$html .= $duration->i . ' Menit';
		
		return $html;
	}
	
	public function getFinalAmountLabel()
	{
		if($this->final_amount > 0) {
			return $this->getFormattedFinalAmount();
		}
		
		$voucher = $this->voucher ? $this->voucher->code : '';
		$transport = $this->transportPrice ? $this->transportPrice->transport->name : '';
		$label = 'Rp 0,-';
		$label .= '<br/>'.Html::tag('small', $transport .' - '. $voucher);
		
		return $label;
	}
	
	public function getFormattedFinalAmount()
	{
		$currency = 'Rp ';
		$amount = FormatConverter::rupiah($this->final_amount);
		$prefix = '-';
		return $currency . $amount . $prefix;
	}
	
	public function getFormattedIndoDateTime($field = null)
	{
		$field = $field ? $this->$field : $this->time_in;
		
		$formatted = FormatConverter::formatIndoDate($field, '%d %B %Y %H:%M:%S');
		$zone = ' WIB';
		
		return $formatted . $zone;
	}
	
	public function getExitDescription()
	{
		if($this->status == self::SCENARIO_ENTRY) {
			return;
		}
		
		if($this->transportPrice->transport->id != Transport::TRANSPORT_MEMBER) {
			return;
		}
		
		$start = FormatConverter::formatIndoDate($this->voucher->start_date, '%d %b %Y');
		$end = FormatConverter::formatIndoDate($this->voucher->end_date, '%d %b %Y');
		$ranges = $start .' - '. $end;
		$limit = DateTime::getDuration(date('Y-m-d'), $this->voucher->end_date);
		$limit = $limit->days > 0 ? $limit->days .' Hari' : 'Terakhir Hari ini';
		
		$html = 'Ket Member: ' . $ranges . '<br/>';
		$html.= 'Sisa ' . $limit .'<br/>';
		
		return $html;
	}
}