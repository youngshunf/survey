<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '发布任务';
$this->params['breadcrumbs'][] = ['label' => '任务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

<div class="box-header width-border"> 
    <div class="box-title" >
        发布任务
    </div>
</div>
    <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
        'group'=>$group
    ]) ?>

</div>
</div>
