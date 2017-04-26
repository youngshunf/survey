<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = '修改管理员: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '平台管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
        修改管理员
    </div>
</div>
    <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>