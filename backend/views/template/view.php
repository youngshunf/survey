<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Template */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '模板管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">
    <p>

        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => '您确定要删除此模板吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'templateno',
           ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
      
        ],
    ]) ?>
    <h5>模板问卷</h5>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'name',
            'code',
             ['attribute'=>'type',
            'label'=>'题型',
            'format'=>'html',
            'value'=>function ($model){
             return CommonUtil::getDescByValue('question', 'type', $model->type);
            }
            ],
            ['attribute'=>'required',
            'label'=>'是否必答',
            'format'=>'html',
            'value'=>function ($model){
                return $model->required==1?'是':'否';
            }
            ],
            ['attribute'=>'options',
            'label'=>'选项',
            'format'=>'html',
            'value'=>function ($model){
              $option="";
              if($model->type==0){
                  $options=json_decode($model->options,true);
                  $i=1;
                  foreach ( $options as $v){
                      $option .='<p><span class="green">选项'.$i++.':</span>'.$v['opt'];
                      if(!empty($v['link'])){
                          $option .=';跳转到:题目'.$v['link'];
                      }
                  }
              }elseif ($model->type==1){
                  $options=json_decode($model->options,true);
                  $i=1;
                  foreach ( $options as $v){
                      $option .='<p><span class="green">选项'.$i++.':</span>'.$v;
                  }
              }
              
              return $option;
            }
            ],
      /*       ['attribute'=>'created_at',
            'label'=>'创建时间',
            'format'=>['date','php:Y-m-d H:i:s']
            ], */


       /*      ['class' => 'yii\grid\ActionColumn',
            'header'=>'操作',
            'options'=>['width'=>'150px'],
            'template'=>'{update-question}{delete-question}',
            'buttons'=>[  
                'update-question'=>function ($url,$model,$key){
                return Html::a('修改 | ',$url,['title'=>'修改']);
                },
                'delete-question'=>function ($url,$model,$key){
                return Html::a('删除',$url,['title'=>'删除','data-confirm'=>'您确定要删除这个问题?']);
                },
            
                ]
            ], */
        ],
        
        'tableOptions'=>['class'=>'table table-striped table-responsive'],
    ]); ?>

</div>
</div>