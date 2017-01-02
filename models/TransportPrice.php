<?php

namespace app\models;

use app\helpers\FormatConverter;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "transport_price".
 *
 * @property integer $id
 * @property integer $transport_id
 * @property integer $vehicle_id
 * @property string $code
 * @property string $name
 * @property string $amount_1
 * @property string $amount_2
 * @property string $amount_3
 * @property string $amount
 * @property intenger $limit
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Transport[] $transport
 * @property Vehicle[] $vehicle
 */
class TransportPrice extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transport_id', 'code', 'name', 'amount', 'status'], 'required'],
            [['transport_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['limit', 'amount_1', 'amount_2', 'amount_3', 'amount'], 'number'],
            [['limit', 'created_at', 'updated_at', 'vehicle_id'], 'safe'],
            [['code', 'name'], 'string', 'max' => 100],
            [['transport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transport::className(), 'targetAttribute' => ['transport_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transport_id' => 'Transport ID',
            'code' => 'Code',
            'name' => 'Name',
            'amount_1' => 'Amount First Hour',
            'amount_2' => 'Amount Second Hours',
            'amount_3' => 'Amount Third Hours',
            'amount' => 'Max Amount',
            'limit' => 'Limit (Within Days)',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTransport()
    {
        return $this->hasOne(Transport::className(), ['id' => 'transport_id']);
    }
	
	/**
     * @return ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
	
	/**
     * @return ActiveQuery
     */
	public function getVouchers()
	{
		return $this->hasMany(Voucher::className(), ['transport_price_id'=>'id']);
	}
	
	/**
	 * 
	 * @param type $level 1 | 2 | 3 or default null
	 * @return string
	 */
	public function getFormattedAmount($level = null) 
	{
		switch ($level) {
			case 1: $value = $this->amount_1; break;
			case 2: $value = $this->amount_2; break;
			case 3: $value = $this->amount_3; break;
			default : $value = $this->amount;
		}
		
		if ($value == 0) {
			return $value;
		}
		
		return FormatConverter::rupiah($value);
	}
	
	public function getTransportWithCode()
	{
		$transport = $this->transport ? $this->transport->name : $this->transport_id;
		
		return $transport . ' - ' . $this->code . ' '. $this->name;
	}
	
	public static function getCodeById($id)
	{
		$query = self::findOne($id);
		if(!$query) {
			return null;
		}
		
		return $query->code;
	}
}
