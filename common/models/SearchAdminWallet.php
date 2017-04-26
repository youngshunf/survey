<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wallet;

/**
 * SearchWallet represents the model behind the search form about `common\models\Wallet`.
 */
class SearchAdminWallet extends Wallet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'safe'],
            [['charge_type', 'balance', 'frozen_amount', 'total_amount'], 'number'],
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
        $query = Wallet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'non_payment' => $this->non_payment,
            'paid' => $this->paid,
            'total_income' => $this->total_income,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'withdrawing' => $this->withdrawing,
        ]);

        $query->andFilterWhere(['like', 'user_guid', $this->user_guid]);

        return $dataProvider;
    }
}
