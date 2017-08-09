<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = '修改项目: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="box box-primary">

<div class="box-header width-border"> 
    <div class="box-title" >
      <?= $this->title ?>
    </div>
</div>

   <div class="box-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
