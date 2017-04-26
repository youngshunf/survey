<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Maintenance */

$this->title = 'Create Maintenance';
$this->params['breadcrumbs'][] = ['label' => 'Maintenances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
