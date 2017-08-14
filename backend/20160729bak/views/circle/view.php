<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Circle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '车友圈管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除此项?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.nick',
            'user.mobile',
            'content:ntext',
            'lng',
            'lat',
            ['attribute'=>'permissions','value'=>CommonUtil::getDescByValue('circle', 'permissions', $model->permissions)],
            'count_reply',
            'count_love',
            'address',
             ['attribute'=>'时间','value'=>CommonUtil::fomatTime($model->created_at)],
        ],
    ]) ?>
    
    <div class="row">
    <?php if(!empty($model->photos)){
        $photos=json_decode($model->photos,true);
        foreach ($photos as $photo){
        ?>
    <div class="col-md-4">
    <div class="panel-white">
    <img alt="" src="<?= yii::getAlias('@photo').'/circle/'.$model->path.'/mobile/'.$photo?>" class="img-responsive">
    </div>
    </div>
    
    <?php }}?>
    </div>

</div>
