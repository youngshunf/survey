<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Circle */

$this->title = 'Create Circle';
$this->params['breadcrumbs'][] = ['label' => 'Circles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
