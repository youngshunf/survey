<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '平台管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
        平台管理员
    </div>
</div>
    <div class="box-body">
    <p>
    <?php if(yii::$app->user->identity->role_id==99 || yii::$app->user->identity->user_guid==$model->user_guid){?>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
     <?php }?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
             ['attribute'=>'role_id',
            'value'=>CommonUtil::getDescByValue('admin_user', 'role_id', $model->role_id)
            ],
            'name',
            'nick',
            'mobile',
            'email:email',
            ['attribute'=>'sex',
            'value'=>CommonUtil::getDescByValue('admin_user', 'sex', $model->sex)
            ],
            'last_ip',
            ['attribute'=>'last_time',
            'format'=>['date','php: Y-m-d H:i:s'],
            ]
        ],
    ]) ?>

</div>
</div>