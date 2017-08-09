<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = '修改店铺信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '店铺管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="panel-white">

    <h5><?= Html::encode($this->title) ?></h5>

    <?= $this->render('_form', [
        'model' => $model,
        'factory'=>$factory,
        'brand'=>$brand
    ]) ?>

</div>
