<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wallet;

/**
 * SearchWallet represents the model behind the search form about `common\models\Wallet`.
 */
class SearchWithdrawRec extends WithdrawRec
{
    /**
     * @inheritdoc
     */
    public $name;
    public $mobile;
    public $address;
    
    public function rules()
    {
        return [
           
            [['name','mobile','address'], 'safe'],
            [['amount','status'], 'number'],
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
        $query = WithdrawRec::find();
        $query->joinWith(['user']);
        $query->select("withdraw_rec.*, user.name,user.mobile,user.address")->orderBy('withdraw_rec.created_at desc');

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
            'amount' => $this->amount,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->name])
        ->andFilterWhere(['like', 'user.mobile', $this->mobile])
        ->andFilterWhere(['like', 'user.address', $this->address]);

        return $dataProvider;
    }
}
