<?php

use common\models\CommonUtil;
?>	
 
 <?php foreach ($taskArr as  $v){?>
 	<ul class="mui-table-view" >
				<li class="mui-table-view-cell task-list" task_guid=<?= $v['task_guid']?>>
					<div class="row">
						<div class="col-xs-8">
							<p class="task-title"><?= $v['name']?></p>	
							<p class="sub">发布:<?= CommonUtil::fomatDate($v['created_at'])?></p>
							<p class="sub">截止:<?= CommonUtil::fomatDate($v['end_time'])?></p>
						</div>
						<div class="col-xs-4">
						<?php if($v['is_show_price']==1){?>
							<p >奖励:<span class="mui-badge mui-badge-danger">￥<?= $v['price']?></span></p>
						<?php }?>
							<p>限额:<span class="green"> <?= $v['number']?>份</span></p>
							<p>距离:<span class="blue"> <?= ($v['dist']*30)>1000?sprintf("%.2f",($v['dist']*30)/1000).'Km':sprintf("%.2f",($v['dist']*30)).'m';?></span></p>
						</div>
						<div class="col-xs-12">
						
							<div class="progress">
			               <div class="progress-bar progress-bar-danger" role="progressbar" 
			                  aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" 	
			                  style="width: <?= round($v['count_done']/$v['number']*100)?>%;">		            
			               </div>
			                </div>
			                <p>
			                <span class="mui-icon mui-icon-location sub"  lng="<?= $v['lng']?>" lat="<?= $v['lat']?>"><?= $v['address']?> </span>
			                <span class="pull-right"><span class="red"><?= $v['count_done']?></span> / <?= $v['number']?></span></p>
						    
						</div>
					</div>
				</li>
				<?php if($v['status']==0){?>
				<li class="mui-table-view-cell">
				   <p style="margin-top: 8px;">
						    	<span class="done-status" ></span>
						    	<a class="btn  btn-success pull-right do-task"  task_guid="<?= $v['task_guid']?>"> 做任务</a>
					 </p>
				</li>
				<?php }?>
				</ul>
<?php }?>