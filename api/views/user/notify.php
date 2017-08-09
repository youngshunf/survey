<?php

use common\models\CommonUtil;

?>	
 <ul class="mui-table-view" style="padding-top: 0">
 <?php foreach ($notify as $v){?>
<li class="mui-table-view-cell mui-media">
		<!--<img class="mui-media-object mui-pull-left" src="../../images/logo.png">-->
		<div class="mui-media-body">
			<p class='mui-ellipsis'>
				<b><?= $v->title?></b>
			</p>
			<p>
				<?= $v->content?>
			</p>
			<p>
				<span class="sub mui-pull-right"><?= CommonUtil::fomatTime($v->created_at)?></span>
			</p>
		</div>
	</li>
	<?php }?>
</ul>