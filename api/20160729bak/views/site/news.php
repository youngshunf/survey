<?php
use common\models\CommonUtil;
/* @var $this yii\web\View */
$this->title = '新闻资讯';
?>

<li class="mui-table-view-cell">
		<h5>汽车资讯 <a class="mui-pull-right">更多</a></h5>				
		</li>
		<?php foreach ($model as $v){?>
		<li class="mui-table-view-cell mui-media">
			<a href="javascript:;">
				<img class="mui-media-object mui-pull-left" src="<?= yii::getAlias('@photo').'/'.$v->path.'thumb/'.$v->photo?>">
				<div class="mui-media-body">
					<div class="title mui-ellipsis"><?= $v->title?><span class="mui-pull-right"><?= CommonUtil::fomatDate($v->created_at)?></span></div>
					<p class='mui-ellipsis'><?= CommonUtil::cutHtml($v->content,20)?></p>
				</div>
			</a>
</li>
    <?php }?>
