<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AutoFactory */

$this->title = '修改车厂信息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '车厂管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id, 'factory_guid' => $model->factory_guid]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="panel-white">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
