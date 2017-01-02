<?php

namespace app\models\search;

use app\models\Voucher;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\helpers\FormatConverter;

/**
 * VoucherSearch represents the model behind the search form about `app\models\Voucher`.
 */
class VoucherSearch extends Voucher
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transport_price_id', 'voucher_type', 'voucher_type_amount', 'limit', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'start_date', 'end_date', 'created_at', 'updated_at', 'from_date', 'to_date', 'filter_date'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Voucher::find()->orderCreated();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'transport_price_id' => $this->transport_price_id,
            'voucher_type' => $this->voucher_type,
            'voucher_type_amount' => $this->voucher_type_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'limit' => $this->limit,
            'amount' => $this->amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
	
	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function reportSearch($params)
    {
        $query = Voucher::find()->orderCreated();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'created_at' => SORT_DESC
				],
			],
        ]);

        $this->load($params);
		
		$this->filter_date = $this->filter_date ? $this->filter_date : 'start_date';
		$this->from_date = $this->from_date . ' 00:00:00';
		$this->to_date = $this->to_date . ' 23:59:59';
		
		$query->andWhere(['between', $this->filter_date, $this->from_date, $this->to_date]);
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'transport_price_id' => $this->transport_price_id,
            'voucher_type' => $this->voucher_type,
            'voucher_type_amount' => $this->voucher_type_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'limit' => $this->limit,
            'amount' => $this->amount,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        $query->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
	
	public function getTotalAmount($dataProvider) {
		$finalAmount = 0;
		if (!empty($dataProvider->getModels())) {
			foreach ($dataProvider->getModels() as $key => $val) {
				$finalAmount += $val->amount;
			}
		}
		$finalAmount = 'Rp '.FormatConverter::rupiah($finalAmount).',-';
		
		return $finalAmount;
	}
}
