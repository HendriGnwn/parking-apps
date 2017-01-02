<?php

namespace app\models;

/**
 * This is the model class for table "gate".
 *
 * @property integer $id
 * @property string $name
 * @property integer $gate_type
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Gate extends BaseActiveRecord
{
	const GATE_TYPE_IN = 1;
	const GATE_TYPE_OUT = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'gate_type', 'status'], 'required'],
            [['gate_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'gate_type' => 'Gate Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
	
	public static function gateTypeLabels()
	{
		return [
			self::GATE_TYPE_IN => 'Gate In',
			self::GATE_TYPE_OUT => 'Gate Out',
		];
	}
	
	public function getGateType()
	{
		$list = self::gateTypeLabels();
		return $list[$this->gate_type] ? $list[$this->gate_type] : $this->gate_type;
	}
}
