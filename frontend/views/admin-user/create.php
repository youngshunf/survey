<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdminUser */

$this->title = 'Create Admin User';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
<div class="box-header width-border"> 
    <div class="box-title" >
        平台管理员
    </div>
</div>
    <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>