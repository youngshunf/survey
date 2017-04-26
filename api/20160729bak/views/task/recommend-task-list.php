<?php

use common\models\CommonUtil;
?>	
 
 <?php foreach ($taskList as $k=> $v){?>
 	
 		<ul class="mui-table-view">
				<li class=" mui-media task-list"  task_guid=<?= $v['task_guid']?>>
						<?php if(!empty($v['photo'])){?>
						<img class="mui-media-object mui-pull-left" src="<?= yii::getAlias('@photo').'/'.$v['path'].'thumb/'.$v['photo']?>" />
						<?php }?>
						<div class="mui-media-body">
							<b><?= $v['name']?></b>
							<p>
								<span class="sub">剩余 : <?= $v['number']-$v['count_done']?></span>
							<?php if($v['is_show_price']==1){?>
								<span class="mui-pull-right"> <span class="orange">￥ <?= $v['price']?> / 单</span></span>
							<?php }?>
							</p>
							<p>
								<span class="sub">截止 : <?= CommonUtil::fomatDate($v['end_time'])?></span>
								<span class="pull-right">
								</span>
							</p>
							<p >
								<span style="font-size: 12px;">地址:<?= $v['address']?> (<?= sprintf("%.2f",($v['dist']*30)/1000).'km'?>)</span>
							</p>
						</div>
				</li>
			</ul>
<?php }?>