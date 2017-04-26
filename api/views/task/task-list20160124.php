<?php

use common\models\CommonUtil;
?>	
 
 <?php foreach ($taskList as $k=> $v){?>
 	<ul class="mui-table-view">
				<li class="mui-table-view-cell task-list"  task_guid=<?= $v['task_guid']?>>
						<p class="task-title mui-ellipsis"><?= $v['name']?></p>
				</li>
				<li class="mui-table-view-cell mui-media task-list"  task_guid=<?= $v['task_guid']?>>
				<?php if(!empty($v['photo'])){?>
						<img class="mui-media-object mui-pull-left" src="<?= yii::getAlias('@photo').'/'.$v['path'].'thumb/'.$v['photo']?>" />
						<?php }?>
						<div class="mui-media-body">
							<p class='mui-ellipsis'>奖励:<span class="red">￥<?= $v['price']?></span>
								<span class="mui-pull-right">
								限额: <span class="green"><?= $v['number']?>份</span></span>
							</p>
							<p>
								<a class="mui-badge mui-badge-danger"><?= CommonUtil::getDescByValue('task', 'type', $v['type'])?></a>
								<a class="mui-badge mui-badge-success"><?= CommonUtil::getDescByValue('task', 'do_type', $v['do_type'])?></a>
								<span class="mui-pull-right sub"><?= CommonUtil::fomatDate($v['created_at'])?></span>
							</p>
							<p>
								<p>
								<a style="font-size: 12px;"><span class="mui-icon mui-icon-location"></span>地址:<?= $v['address']?></a>
								<span class="mui-pull-right sub">距离:<?= ($v['dist']*30)>1000?sprintf("%.2f",($v['dist']*30)/1000).'Km':sprintf("%.2f",($v['dist']*30)).'m';?></span>
							</p>
							</p>
						</div>
				</li>
				<li class="mui-table-view-cell">
				 <p class="center">
						<button class="btn btn-danger get-task"  task_guid="<?= $v['task_guid']?>"> 领取任务</a>
					</p>
				</li>
			</ul>
<?php }?>