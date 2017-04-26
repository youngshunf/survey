<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminUser;

/**
 * SearchAdminUser represents the model behind the search form about `common\models\AdminUser`.
 */
class SearchAdminUser extends AdminUser
{
    public $role;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id','username', 'password', 'password_hash', 'auth_key', 'password_reset_token', 'user_guid', 'name', 'nick', 'sex', 'img_path', 'last_ip', 'last_time', 'mobile', 'status', 'email', 'parent_user'], 'safe'],
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
        $query = AdminUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(!empty($this->role)){
            $query->andWhere([
                'role_id' => $this->role,
                'parent_user'=>$this->parent_user
            ]);
        }
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nick', $this->nick])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'img_path', $this->img_path])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
