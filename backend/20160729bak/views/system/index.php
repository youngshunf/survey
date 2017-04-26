<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'app首页轮播图';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增图片', ['create-home-photo'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'title',
             'url',        
             ['attribute'=>'photo',
                'label'=>'图片',
                'format'=>'html',
                'value'=>function ($model){
                return Html::img(yii::getAlias('@photo').'/'.$model->path.'/thumb/'.$model->photo,['class'=>'img-responsive','width'=>'50px']);
             }
             ],
             ['attribute'=>'创建时间','value'=>function ($model){
               return CommonUtil::fomatTime($model->created_at);
            }],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view-photo}{update-photo}{delete-photo}',
                'buttons'=>[
                    'view-photo'=>function ($url,$model,$key){
                        return  Html::a('查看 | ', $url, ['title' => '查看详情'] );
                    },
                    'update-photo'=>function ($url,$model,$key){
                    return  Html::a('修改 | ', $url, ['title' => '修改'] );
                    },
                    'delete-photo'=>function ($url,$model,$key){
                    return  Html::a('删除 ', $url, ['title' => '删除','data'=>['confirm'=>'您确定要删除此条数据？']] );
                    },
                  
                    
                    ]
            ],
        ],
    ]); ?>

</div>
