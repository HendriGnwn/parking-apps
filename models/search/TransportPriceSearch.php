<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransportPrice;

/**
 * TransportPriceSearch represents the model behind the search form about `app\models\TransportPrice`.
 */
class TransportPriceSearch extends TransportPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transport_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'limit', 'created_at', 'updated_at'], 'safe'],
            [['amount_1', 'amount_2', 'amount_3', 'amount'], 'number'],
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
        $query = TransportPrice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		
		$query->orderBy(['transport_id'=>SORT_ASC]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'transport_id' => $this->transport_id,
            'amount_1' => $this->amount_1,
            'amount_2' => $this->amount_2,
            'amount_3' => $this->amount_3,
            'amount' => $this->amount,
            'limit' => $this->limit,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
