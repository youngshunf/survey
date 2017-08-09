<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Template */

$this->title = '创建模板';
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
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>