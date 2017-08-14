<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserEnterprise */

$this->title = 'Update User Enterprise: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Enterprises', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-enterprise-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
