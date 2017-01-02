<?php

namespace app\models;

use app\helpers\FormatConverter;
use app\models\TransportPrice;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "voucher".
 *
 * @property integer $id
 * @property string $code
 * @property integer $transport_price_id
 * @property integer $vehicle_id
 * @property integer $voucher_type
 * @property integer $voucher_type_amount
 * @property string $start_date
 * @property string $end_date
 * @property integer $limit
 * @property string $amount
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * 
 * @property TransportPrice[] $transportPrice
 * @property Vehicle[] $vehicle
 */
class Voucher extends BaseActiveRecord
{
	const VOUCHER_TYPE_CODE = 1;
	const VOUCHER_TYPE_POLICE_NUMBER = 2;
	
	const VOUCHER_TYPE_AMOUNT_FIX = 1;
	const VOUCHER_TYPE_AMOUNT_PERCENT = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'voucher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'voucher_type', 'voucher_type_amount', 'start_date', 'limit', 'amount', 'status', 'vehicle_id'], 'required'],
            [['transport_price_id', 'voucher_type', 'voucher_type_amount', 'limit', 'status', 'created_by', 'updated_by'], 'integer'],
            [['transport_price_id', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
			[['start_date', 'end_date'], 'date', 'format'=>'php:Y-m-d'],
            [['amount'], 'number'],
            [['code'], 'string', 'max' => 100],
        ];
    }
	
	public function beforeSave($insert) 
	{
		if ($this->voucher_type == self::VOUCHER_TYPE_POLICE_NUMBER) {
			$this->end_date = FormatConverter::formatDateInterval($this->start_date, $this->limit);
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
            'code' => 'Kode / No Polisi',
            'transport_price_id' => 'Jenis - Jenis Kendaraan',
            'voucher_type' => 'Jenis Kode Voucher',
            'voucher_type_amount' => 'Jenis Harga Voucher',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'limit' => 'Limit (Hari)',
            'amount' => 'Harga',
            'status' => 'Status',
            'created_at' => 'Dibuat di',
            'updated_at' => 'Diedit di',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Diedit oleh',
        ];
    }
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getTransportPrice()
	{
		return $this->hasOne(TransportPrice::className(), ['id'=>'transport_price_id'])->active();
	}
	
	/**
	 * 
	 * @return ActiveQuery
	 */
	public function getVechine()
	{
		return $this->hasOne(Vechine::className(), ['id'=>'vechine_id'])->active();
	}
	
	public static function voucherTypeLabels()
	{
		return [
			//self::VOUCHER_TYPE_CODE => 'Kode Voucher',
			self::VOUCHER_TYPE_POLICE_NUMBER => 'Nomor Polisi',
		];
	}
	
	public static function voucherTypeAmountLabels()
	{
		return [
			self::VOUCHER_TYPE_AMOUNT_FIX => 'Harga Pasti',
			self::VOUCHER_TYPE_AMOUNT_PERCENT => 'Harga dalam Persen (%)'
		];
	}
	
	public function getVoucherType()
	{
		$list = self::voucherTypeLabels();
		return $list[$this->voucher_type] ? $list[$this->voucher_type] : $this->voucher_type;
	}
	
	public function getVoucherTypeAmount()
	{
		$list = self::voucherTypeAmountLabels();
		return $list[$this->voucher_type_amount] ? $list[$this->voucher_type_amount] : $this->voucher_type_amount;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFormattedAmount() 
	{
		switch ($this->voucher_type_amount) {
			case self::VOUCHER_TYPE_AMOUNT_FIX :
				return 'Rp. ' . FormatConverter::rupiah($this->amount);
			case self::VOUCHER_TYPE_AMOUNT_PERCENT :
				return $this->amount . '%';
		}
	}
	
	/**
	 * active data = today is more than start date, less than end date and status is actived
	 * 
	 * @param type $code
	 * @param type $vehicle
	 * @return app\models\Voucher
	 */
	public static function getActiveVoucherByCodeAndVehicle($code, $vehicle)
	{
		$today = date('Y-m-d');
		
		/** member query */
		$query = self::find()
				->join('INNER JOIN', 'transport_price', 'transport_price.id = voucher.transport_price_id')
				->andWhere(['voucher.code'=>$code, 'voucher.status'=>self::STATUS_ACTIVE, 'voucher.vehicle_id'=>$vehicle, 'transport_price.transport_id'=>Transport::TRANSPORT_MEMBER])
				->andFilterWhere(['<=', 'voucher.start_date', $today])
				->andFilterWhere(['>=', 'voucher.end_date', $today])
				->limit(1)
				->one();
		
		if (!$query) {
			/** employee query */
			$query = self::find()
					->join('INNER JOIN', 'transport_price', 'transport_price.id = voucher.transport_price_id')
					->andWhere(['voucher.code'=>$code, 'voucher.status'=>self::STATUS_ACTIVE, 'voucher.vehicle_id'=>$vehicle, 'transport_price.transport_id'=>Transport::TRANSPORT_EMPLOYEE])
					->limit(1)
					->one();
		}
		
		return $query;
	}
	
	public function isVoucherTypeCode()
	{
		return $this->voucher_type == self::VOUCHER_TYPE_CODE;
	}
	
	public function isVoucherTypePoliceNumber()
	{
		return $this->voucher_type == self::VOUCHER_TYPE_POLICE_NUMBER;
	}
	
	/**
	 * get calculate with voucher
	 * 
	 * @param type $amount
	 * @return type
	 */
	public function getVoucherAmount($amount)
	{
		if ($this->voucher_type == self::VOUCHER_TYPE_AMOUNT_PERCENT) {
            $voucherAmount = ($this->amount * $amount / 100);
        } else {
            $voucherAmount = 0;
        }

        return round($voucherAmount);
	}
	
	public static function filterDates()
	{
		$self = (object)(new self())->attributeLabels();
		
		return [
			'start_date' => $self->start_date,
			'end_date' => $self->end_date,
			'created_at' => $self->created_at,
		];
	}
	
}
