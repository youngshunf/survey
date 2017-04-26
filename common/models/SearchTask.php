<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * SearchTask represents the model behind the search form about `common\models\Task`.
 */
class SearchTask extends Task
{
    /**
     * @inheritdoc
     */
    public $search_start_time;
    public $search_end_time;
    public function rules()
    {
        return [
            [['type','do_type','post_type', 'number', 'end_time', 'radius', 'status', 'created_at', 'updated_at', 'group_id','project_id','latest_submit_time','count_done'], 'integer'],
            [['task_guid', 'user_guid', 'name', 'desc', 'province', 'city', 'district', 'address', 'lng', 'lat'], 'safe'],
            [['price', 'total_price'], 'number'],
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
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $searchTask=yii::$app->request->get('SearchTask');
        if(!empty($searchTask)){
            $this->search_start_time=@$searchTask['search_start_time'];
            $this->search_end_time=@$searchTask['search_end_time'];
        }
        
        
        if(!empty($this->search_start_time) && !empty($this->search_end_time)){
            $start=strtotime($this->search_start_time);
            $end=strtotime($this->search_end_time);
            $query->andWhere(" created_at > $start and created_at < $end");
        }elseif (!empty($this->search_start_time)){
            $start=strtotime($this->search_start_time);
            $query->andWhere(" created_at > $start ");
        }elseif (!empty($this->search_end_time)){
            $end=strtotime($this->search_end_time);
            $query->andWhere(" created_at < $end");
        }
        
        if($this->count_done==1){
            $query->orderBy('count_done desc');
        }elseif ($this->count_done==2){
            $query->orderBy('count_done asc');
        }
        
        if($this->latest_submit_time==1){
            $query->orderBy('latest_submit_time desc,created_at desc');
        }elseif ($this->latest_submit_time==2){
            $query->orderBy('latest_submit_time asc,created_at desc');
        }
        
        if(empty($this->count_done)&&empty($this->latest_submit_time)){
            $query->orderBy('created_at desc');
        }

        $query->andFilterWhere([
            'project_id'=>$this->project_id,
            'type' => $this->type,
            'do_type' => $this->do_type,
            'post_type' => $this->post_type,
            'price' => $this->price,
            'number' => $this->number,
            'end_time' => $this->end_time,
            'radius' => $this->radius,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'total_price' => $this->total_price,
            'group_id' => $this->group_id,
            'user_guid'=>$this->user_guid,
        ]);
        
       

        $query ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'lng', $this->lng])
            ->andFilterWhere(['like', 'lat', $this->lat]);

        return $dataProvider;
    }
}
