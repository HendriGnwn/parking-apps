<?php

namespace app\models;

use app\helpers\DateTime;
use app\helpers\FormatConverter;
use app\models\query\TransactionQuery;
use barcode\barcode\BarcodeGenerator;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\httpclient\Exception;
use yii\web\UploadedFile;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $code
 * @property string $police_number
 * @property integer $gate_in_id
 * @property string $time_in
 * @property string $camera_in
 * @property string $camera_out
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
	const SCENARIO_MANUAL_INPUT = 'manualInput';
	const SCENARIO_PREPARE_DATA_BEFORE_EXIT = 'prepareDataBeforeExit';
	
	const CODE_PREFIX = '';
	
	const STATUS_ENTRY = 1;
	const STATUS_EXIT = 2;
	const STATUS_ENTRY_EXIT = 3;
	const STATUS_MANUAL_INPUT = 4;
	
	const PAYMENT_STATUS_DRAFT = 1;
	const PAYMENT_STATUS_WAITING = 5;
	const PAYMENT_STATUS_PAID = 10;
	
	const TIME_00 = '00:00:00';
	const TIME_24 = '23:59:59';
	
	public $motocycle;
	public $car;
	public $big_car;
	public $date;
	
	public $path;
	
	/**
	 * @var UploadedFile
	 */
	public $cameraFileUpload;
	
	public function init() 
	{
		parent::init();
		
		$path = 'web/files/transactions/';
		$this->path = $path;
		
		if(!is_dir(Yii::getAlias('@app/' .$path))) {
			mkdir(Yii::getAlias('@app/' .$path)); 
		}
		
		return true;
	}

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
			[['gate_in_id', 'time_in'], 'required', 'on'=> [self::SCENARIO_ENTRY, self::SCENARIO_ENTRY_AND_EXIT]],
			[['police_number', 'code', 'gate_out_id', 'time_out', 'payment_id', 'final_amount', 'transport_price_id'], 'required', 'on'=>self::SCENARIO_EXIT],
			[['police_number', 'payment_id', 'final_amount', 'transport_price_id'], 'required', 'on'=>self::SCENARIO_ENTRY_AND_EXIT],
			[['police_number', 'payment_id', 'final_amount', 'time_out', 'transport_price_id', 'gate_out_id'], 'required', 'on'=>self::SCENARIO_MANUAL_INPUT],
            [['gate_in_id', 'gate_out_id', 'status', 'payment_status', 'transport_price_id', 'payment_id', 'voucher_id', 'created_by', 'updated_by'], 'integer'],
            [['code', 'police_number', 'gate_in_id', 'time_in', 'gate_out_id', 'time_out', 'status', 
				'vehicle_id', 'payment_status', 'transport_price_id', 'payment_id', 'voucher_id', 'final_amount', 'created_at', 'updated_at', 'picture'], 'safe'],
            [['final_amount'], 'number'],
			[['transport_price_id'], 'required', 'on'=> [self::SCENARIO_PREPARE_DATA_BEFORE_EXIT]],
            [['camera_in', 'camera_out', 'police_number', 'transport_price_id'], 'safe'],
			[['payment_status'], 'default', 'value'=>self::PAYMENT_STATUS_DRAFT],
			[['status'], 'default', 'value'=>self::STATUS_ENTRY],
			['police_number', 'match', 'pattern'=>'/^([\w\S])+$/', 'message'=>"{attribute} jangan memakai spasi"],
            [['code', 'police_number'], 'string', 'max' => 100],
            [['picture'], 'string', 'max' => 200],
			[['time_out'], 'validateTime'],
			[['cameraFileUpload'], 'file', 'skipOnEmpty'=>true, 'checkExtensionByMimeType'=>false,
				'extensions'=>['png', 'jpg'],
				'maxSize' => 1024 * 1024 * 1],
        ];
    }
	
	/**
	 * - delete file in path
	 * 
	 * @return type
	 */
	public function beforeDelete() 
	{
		/* todo: delete the corresponding file in storage */
		$this->deleteCameraInFile();
		$this->deleteCameraOutFile();
				
		return parent::beforeDelete();
	}
	
	private function deleteCameraInFile()
	{
		@unlink(Yii::getAlias('@app/' . $this->path) . $this->camera_in);
	}
	
	private function deleteCameraOutFile()
	{
		@unlink(Yii::getAlias('@app/' . $this->path) . $this->camera_out);
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
			
			$this->processUploadCameraInFile();
		}
		
		if ($this->scenario == self::SCENARIO_PREPARE_DATA_BEFORE_EXIT) {
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
		
		if ($this->scenario == self::SCENARIO_MANUAL_INPUT) {
			$this->payment_status = self::PAYMENT_STATUS_PAID;
			$this->status = self::STATUS_EXIT;
			
			$calculate = $this->calculateByParams();
			$this->final_amount = $calculate['final_amount'];
			$this->transport_price_id = $calculate['transport_price_id'];
			$this->voucher_id = $calculate['voucher_id'];
		}
		
		return parent::beforeSave($insert);
	}
	
	/**
	 * process upload file
	 * 
	 * @return boolean
	 */
	public function processUploadCameraInFile()
	{
		if (!empty($this->cameraFileUpload)) {
			$this->deleteCameraInFile();
			
			$path = str_replace('web/', '', $this->path);
			$this->cameraFileUpload->saveAs($path . $this->generateCameraInFile(true));
		
			$this->camera_in = $this->generateCameraInFile(true);
		}
		
		return true;
	}
	
	/**
	 * generate file name
	 * 
	 * @param type $withExt false
	 * @return type
	 */
	public function generateCameraInFile($withExt = false)
	{
		$prefix = $this->vehicle_id . '-' . $this->gate_in_id;
		$trim   = trim($prefix);
		$name	= str_replace(' ', '-', $trim).'-'.$this->time_in;
		$name = Inflector::slug($name);
		
		$ext = $withExt ? '.' . $this->cameraFileUpload->extension : '';
		
		return $name . $ext;
	}
	
	/**
	 * process upload file
	 * 
	 * @return boolean
	 */
	public function processUploadCameraOutFile()
	{
		if (!empty($this->cameraFileUpload)) {
			$this->deleteCameraOutFile();
			
			$path = str_replace('web/', '', $this->path);
			$this->cameraFileUpload->saveAs($path . $this->generateCameraOutFile(true));
		
			$this->camera_out = $this->generateCameraOutFile(true);
		}
		
		return true;
	}
	
	/**
	 * generate file name
	 * 
	 * @param type $withExt false
	 * @return type
	 */
	public function generateCameraOutFile($withExt = false)
	{
		$prefix = $this->vehicle_id . '-' . $this->gate_out_id;
		$trim   = trim($prefix);
		$name	= str_replace(' ', '-', $trim).'-'.$this->time_out;
		$name = Inflector::slug($name);
		
		$ext = $withExt ? '.' . $this->cameraFileUpload->extension : '';
		
		return $name . $ext;
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
            'camera_in' => 'Foto Kendaraan Masuk',
            'camera_out' => 'Foto Kendaraan Keluar',
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
    public function generateCode($padLength = 9)
    {
		$prefix = self::CODE_PREFIX;
		
		$transportPriceCode = TransportPrice::getCodeById($this->transport_price_id);
		$prefix = $prefix . $transportPriceCode;
		
        $left = $prefix . date('ymd');
        $leftLen = strlen($left);
        $increment = rand(100000, 50000);

        $last = self::find()
            ->select('code')
            ->where(['LIKE', 'code', $left])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->scalar();

        if ($last) {
            $increment = (int) substr($last, $leftLen, $padLength);
            $increment += rand(100000, 50000);
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
	
	public function getCameraInUrl()
	{
		return Url::to("@" . $this->path . $this->camera_in);
	}
	
	public function getCameraInImg()
	{
		return Html::img($this->getCameraInUrl(), ['width' => '300px']);
	}
	
	public function getCameraInImgHtml()
	{
		return Html::a($this->getCameraInImg(), $this->getCameraInUrl(), ['target' => '_blank']);
	}
	
	public function getCameraOutUrl()
	{
		return Url::to("@" . $this->path . $this->camera_out);
	}
	
	public function getCameraOutImg()
	{
		return Html::img($this->getCameraOutUrl(), ['width' => '300px']);
	}
	
	public function getCameraOutImgHtml()
	{
		return Html::a($this->getCameraOutImg(), $this->getCameraOutUrl(), ['target' => '_blank']);
	}
	
	public function printVehicleExit()
	{
		try {
			//$connector = new CupsPrintConnector("EPSON_TM-T82-S_A"); // for linux with cups printer
			$connector = new WindowsPrintConnector("EPSON_TM-T82-S_A"); // for windows


			/* Print a "Hello world" receipt" */
			$printer = new Printer($connector);

			$printer->setPrintLeftMargin(4);
			$printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
			$printer->setJustification(Printer::JUSTIFY_CENTER);

			$printer->setTextSize(2, 1);
			$printer->text(Setting::getAppName());
			$printer->feed(1);

			$companyAddress = wordwrap(Setting::getCompanyAddress(), 40);
			$printer->setTextSize(1, 1);
			$printer->text($companyAddress);
			$printer->feed(1);
			
			$companyPhone = wordwrap(Setting::getCompanyPhone(), 40);
			$printer->setTextSize(1, 1);
			$printer->text($companyPhone);
			$printer->feed(1);
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setTextSize(1, 1);
			$printer->text("-----------------------------------------------");
			$printer->text("\n");
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setTextSize(1, 1);
			$printer->text(($this->gateOut ? $this->gateOut->name . ' / ' : '') . ($this->vehicle ? $this->vehicle->name : ''));
			$printer->text("\n");
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setTextSize(1, 1);
			$printer->text("No Trx : " . $this->code);
			$printer->text("\n");
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setTextSize(1, 1);
			$printer->text("Nopol : " . $this->police_number);
			$printer->text("\n");
			
			$printer->setTextSize(1, 1);
			$printer->text("Masuk : " . $this->getFormattedIndoDateTime());
			$printer->text("\n");
			
			$printer->setTextSize(1, 1);
			$printer->text("Keluar : " . $this->getFormattedIndoDateTime('time_out'));
			$printer->text("\n");

			$printer->setTextSize(1, 1);
			$printer->text("Lama Parkir : " . $this->getDiffTimeInOut());
			$printer->text("\n");

			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(2, 1);
			$printer->text("\n");
			$printer->text($this->getFinalAmountLabel());
			$printer->text("\n");
			$printer->text("\n");

			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->setTextSize(1, 1);
			$printer->text(wordwrap(Setting::getCompanyName() . ' - ' . ($this->updatedBy ? $this->updatedBy->getIdentityName() : ''), 40));
			$printer->feed(1);
			$printer->text("\n");
			
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->setTextSize(1, 1);
			$printer->text("-----------------------------------------------");
			$printer->text("\n");
			
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text(wordwrap(Setting::getStructExitFooter(), 40));
			$printer->feed(1);

			$printer->cut();

			/* Close printer */
			$printer -> close();
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	}
}