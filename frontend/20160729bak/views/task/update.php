<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '修改任务: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
<div class="box-header width-border"> 
    <div class="box-title" >
        <?= Html::encode($this->title) ?>
    </div>
</div>
    <div class="box-body">



    <?= $this->render('_form', [
        'model' => $model,
        'group'=>$group
    ]) ?>

</div>
</div>