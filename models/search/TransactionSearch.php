<?php

namespace app\models\search;

use app\helpers\FormatConverter;
use app\models\Transaction;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransactionSearch represents the model behind the search form about `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gate_in_id', 'gate_out_id', 'status', 'payment_status', 
				'transport_price_id', 'payment_id', 'voucher_id', 'created_by', 'updated_by'], 'integer'],
            [['code', 'police_number', 'time_in', 'time_out', 'picture', 
				'created_at', 'updated_at', 'from_date', 'to_date', 'filter_date',
				'motocycle', 'car', 'big_car', 'date',
				'date', 'motocycle', 'car', 'big_car'], 'safe'],
            [['final_amount'], 'number'],
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
        $query = Transaction::findByRole();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		
		$query->addOrderBy(['created_at' => SORT_DESC]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gate_in_id' => $this->gate_in_id,
            'time_in' => $this->time_in,
            'gate_out_id' => $this->gate_out_id,
            'time_out' => $this->time_out,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'transport_price_id' => $this->transport_price_id,
            'payment_id' => $this->payment_id,
            'voucher_id' => $this->voucher_id,
            'final_amount' => $this->final_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'police_number', $this->police_number])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
	
	/**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchToday($params)
    {
        $query = Transaction::find();
		
		$user = Yii::$app->user;
		if(!$user->can('superadmin') || !$user->can('owner')) {
			$query->andWhere([
				'updated_by' => $user->id,
			]);
		}

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination'=>false,
        ]);

        $this->load($params);
		
		$query->andWhere(['>=', 'DATE_FORMAT(created_at, "%Y-%m-%d")', date('Y-m-d')]);
		$query->addOrderBy(['created_at' => SORT_DESC]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gate_in_id' => $this->gate_in_id,
            'time_in' => $this->time_in,
            'gate_out_id' => $this->gate_out_id,
            'time_out' => $this->time_out,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'transport_price_id' => $this->transport_price_id,
            'payment_id' => $this->payment_id,
            'voucher_id' => $this->voucher_id,
            'final_amount' => $this->final_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'police_number', $this->police_number])
            ->andFilterWhere(['like', 'picture', $this->picture]);

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
        $query = Transaction::findByRole();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => false,
			'sort' => [
				'defaultOrder' => [
					'created_at' => SORT_DESC
				],
			],
        ]);

        $this->load($params);
		
		$this->filter_date = $this->filter_date ? $this->filter_date : 'time_in';
		$this->from_date = $this->from_date ? $this->from_date : date('Y-m-d');
		$this->to_date = $this->to_date ? $this->to_date : date('Y-m-d');
		
		$query->andWhere(['between', $this->filter_date, $this->from_date, $this->to_date]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gate_in_id' => $this->gate_in_id,
            'time_in' => $this->time_in,
            'gate_out_id' => $this->gate_out_id,
            'time_out' => $this->time_out,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'transport_price_id' => $this->transport_price_id,
            'payment_id' => $this->payment_id,
            'voucher_id' => $this->voucher_id,
            'final_amount' => $this->final_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'police_number', $this->police_number])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
	
	public function getTotalAmount($dataProvider) {
		$finalAmount = 0;
		if (!empty($dataProvider->getModels())) {
			foreach ($dataProvider->getModels() as $key => $val) {
				$finalAmount += $val->final_amount;
			}
		}
		$finalAmount = 'Rp '.FormatConverter::rupiah($finalAmount).',-';
		
		return $finalAmount;
	}
	
	public function getTotalField($dataProvider, $field) {
		$total = 0;
		if (!empty($dataProvider->getModels())) {
			foreach ($dataProvider->getModels() as $key => $val) {
				$total += $val->$field;
			}
		}
		
		return $total;
	}
	
	public function reportRecapitulation($params)
	{
		$query = Transaction::find();
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => false,
			'sort' => [
				'defaultOrder' => [
					'created_at' => SORT_DESC
				],
			],
        ]);

        $this->load($params);
		
		$this->filter_date = $this->filter_date ? $this->filter_date : 'created_at';
		$this->from_date = $this->from_date ? $this->from_date : date('Y-m-d');
		$this->to_date = $this->to_date ? $this->to_date : date('Y-m-d');
		
		$this->from_date = $this->from_date . ' 00:00:00';
		$this->to_date = $this->to_date . ' 23:59:59';
		
		$query->addSelect([
			'*',
			'DATE_FORMAT('.$this->filter_date.', "%Y-%m-%d") AS date',
			'COUNT(CASE WHEN vehicle_id = 1 THEN 1 ELSE NULL END) AS motocycle',
			'COUNT(CASE WHEN vehicle_id = 2 THEN 1 ELSE NULL END) AS car',
			'COUNT(CASE WHEN vehicle_id = 3 THEN 1 ELSE NULL END) AS big_car',
			'COUNT(voucher_id) AS voucher_id',
			'SUM(final_amount) AS final_amount',
		]);
		
		$query->andWhere(['between', $this->filter_date, $this->from_date, $this->to_date]);
		
		$query->andWhere(['status'=>self::STATUS_EXIT]);
		
		$query->addGroupBy([
			'date_format('.$this->filter_date.', "%Y-%m-%d")',
			'created_by',
		]);
		
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gate_in_id' => $this->gate_in_id,
            'time_in' => $this->time_in,
            'gate_out_id' => $this->gate_out_id,
            'time_out' => $this->time_out,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'transport_price_id' => $this->transport_price_id,
            'payment_id' => $this->payment_id,
            'voucher_id' => $this->voucher_id,
            'final_amount' => $this->final_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'police_number', $this->police_number])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
	}
}
