<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Transaction]].
 *
 * @see \app\models\Transaction
 */
class TransactionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Transaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Transaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
	
	public function isOwnerCreated()
	{
		return $this->andWhere(['created_by' => \Yii::$app->user->id]);
	}
}
