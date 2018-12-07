<?php

namespace thienhungho\OrderManagement\modules\OrderManage\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use thienhungho\OrderManagement\modules\OrderBase\Order;

/**
 * thienhungho\OrderManagement\modules\MyOrder\search\OrderSearch represents the model behind the search form about `thienhungho\OrderManagement\modules\OrderBase\Order`.
 */
 class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ref_by', 'created_by', 'updated_by'], 'integer'],
            [['status', 'payment_method', 'note', 'include_vat', 'customer_username', 'customer_phone', 'customer_name', 'customer_email', 'customer_address', 'customer_company', 'customer_area', 'customer_tax_number', 'created_at', 'updated_at', 'real_value', 'discount_value', 'total_price'], 'safe'],
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
        $query = Order::find();

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
            'ref_by' => $this->ref_by,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'include_vat', $this->include_vat])
            ->andFilterWhere(['like', 'customer_username', $this->customer_username])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'customer_address', $this->customer_address])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'customer_area', $this->customer_area])
            ->andFilterWhere(['like', 'customer_tax_number', $this->customer_tax_number])
            ->andFilterWhere(['like', 'real_value', $this->real_value])
            ->andFilterWhere(['like', 'discount_value', $this->discount_value])
            ->andFilterWhere(['like', 'total_price', $this->total_price])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->created_at]);

        return $dataProvider;
    }
}
