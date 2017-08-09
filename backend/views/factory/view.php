<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\AutoFactory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auto Factories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id, 'factory_guid' => $model->factory_guid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id, 'factory_guid' => $model->factory_guid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'short_name',
            'province',
            'city',
            'address',
            'postcode',
            'telzone',
            'telephone',
            'mobile',
            'fax',
            'contact',
            ['attribute'=>'创建时间','value'=>CommonUtil::fomatTime($model->created_at)],
            ['attribute'=>'更新时间','value'=>CommonUtil::fomatTime($model->updated_at)],
         
        ],
    ]) ?>

</div>
