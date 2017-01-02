<?php

namespace app\models;

use app\models\query\BaseActiveRecordQuery;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * parent class of model
 * 
 * @author Hendri <hendri.gnw@gmail.com>
 */

class BaseActiveRecord extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
	
	public $from_date;
	public $to_date;
	public $filter_date;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id'=>'created_by']);
    }

    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id'=>'updated_by']);
    }

    public static function statusLabels() {
        return [
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE',
        ];
    }

    public function getStatusLabel() {
        return $this->statusLabels()[$this->status];
    }

    public function getStatusWithStyle() {
        switch($this->status) {
            case self::STATUS_ACTIVE: return Html::label($this->getStatusLabel(), null, ['class'=>'label label-success']);
            case self::STATUS_INACTIVE: return Html::label($this->getStatusLabel(), null, ['class'=>'label label-danger']);
        }
    }
	
	/**
     * @inheritdoc
     * @return BaseActiveRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BaseActiveRecordQuery(get_called_class());
    }
}