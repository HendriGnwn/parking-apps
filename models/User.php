<?php

namespace app\models;

use dektrium\user\controllers\SecurityController;
use dektrium\user\models\User as BaseUser;
use Yii;

/**
 * @property integer $online
 * @property integer $online_date
 */

class User extends BaseUser
{	
	const ONLINE_TRUE = 1;
	const ONLINE_FALSE = 0;
	
	public function init()
	{
		parent::init();
		
		$this->on(SecurityController::EVENT_AFTER_LOGIN, [$this, 'afterLogin']);
		$this->on(SecurityController::EVENT_AFTER_LOGOUT, [$this, 'afterLogout']);
	}
	
    public function getGate()
	{
		return $this->hasOne(Gate::className(), ['gate_id' => 'id']);
	}
	
	/**
	 * Event after login
	 */
	public function afterLogin($username)
	{
		$query = self::find()->where(['username'=>$username])->one();
		$query->online = self::ONLINE_TRUE;
		$query->online_date = date('Y-m-d H:i:s');
		return $query->update();
	}
	
	/**
	 * Event after logout
	 */
	public function afterLogout($id)
	{
		$query = self::findOne($id);
		$query->online = self::ONLINE_FALSE;
		return $query->update();
	}
	
	/**
	 * event after update profile
	 * 
	 * @param type $id
	 * @param type $params
	 * @return type
	 */
	public function afterUpdateProfile($id, $params = [])
	{
		$query = self::findOne($id);
		$query->shift_id = $params['shift_id'];
		$query->gate_id = $params['gate_id'];
		return $query->update();
	}
	
	public function getIdentityName()
	{
		if($this->profile) {
			if($this->profile->name != '') {
				return $this->profile->name;
			}
		}
		return $this->username;
	}
	
	public static function listActiveUser()
	{
		$query = self::find()->where(['blocked_at'=>null])->all();
		return $query;
	}
}
