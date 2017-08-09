<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Template;

/**
 * SearchTemplate represents the model behind the search form about `common\models\Template`.
 */
class SearchTemplate extends Template
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_auth', 'created_at'], 'integer'],
            [['name', 'user_guid', 'templateno'], 'safe'],
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
        $query = Template::find()->orderBy('created_at desc');

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
            'is_auth' => $this->is_auth,
            'created_at' => $this->created_at,
            'user_guid'=>$this->user_guid
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'templateno', $this->templateno]);

        return $dataProvider;
    }
}
