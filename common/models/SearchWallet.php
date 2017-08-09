<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wallet;

/**
 * SearchWallet represents the model behind the search form about `common\models\Wallet`.
 */
class SearchWallet extends Wallet
{
    /**
     * @inheritdoc
     */
    public $name;
    public $mobile;
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['user_guid','name','mobile'], 'safe'],
            [['non_payment', 'paid', 'total_income', 'withdrawing'], 'number'],
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
        $query->joinWith(['user']);
        $query->select("wallet.*, user.*")->orderBy('wallet.created_at desc');

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
        $query->andFilterWhere(['like', 'user.name', $this->name])
        ->andFilterWhere(['like', 'user.mobile', $this->mobile]);

        return $dataProvider;
    }
}
