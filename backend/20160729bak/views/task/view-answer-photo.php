<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '答案图片';
$this->params['breadcrumbs'][] = $this->title;
?>

 <?php foreach ($answerDetail as $k=>$v){?>
 
 <img src="<?= yii::getAlias('@photo').'/'.$v->path.$v->photo?>">
 
 <?php }?>

