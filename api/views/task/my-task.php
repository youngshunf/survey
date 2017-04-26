<?php

use common\models\CommonUtil;
?>	
 
 <?php foreach ($taskArr as  $v){
    if(!empty($v['task'])){
     ?>
 
<ul class="mui-table-view" >
				<li class="mui-media task-list"  task_guid=<?= $v['task']['task_guid']?>>
						<?php if(!empty($v['task']['photo'])){?>
						<img class="mui-media-object mui-pull-left" src="<?= yii::getAlias('@photo').'/'.$v['task']['path'].'thumb/'.$v['task']['photo']?>" />
						<?php }?>
						<div class="mui-media-body">
							<b><?= $v['task']['name']?></b>
							<p>
								<span class="sub">剩余 : <?= $v['task']['number']-$v['task']['count_done']?></span>
								<?php if($v['task']['is_show_price']==1){?>
								<span class="mui-pull-right"> <span class="orange">￥ <?= $v['task']['price']?> / 单</span></span>
							<?php }?>
							</p>
							<p>
								<span class="sub">截止 : <?= CommonUtil::fomatDate($v['task']['end_time'])?></span>
								<span class="pull-right">
								</span>
							</p>
							<p >
								<span style="font-size: 12px;">地址:<?= $v['task']['address']?> （<?= sprintf("%.2f",($v['task']['dist']*30)/1000).'km'?>）</span>
							</p>
						</div>
				</li>
				<li class="">
				 <p style="margin-top: 8px;">
						    	<span class="done-status" ></span>
						    	<span class="mui-badge mui-badge-warning">
						    	<?= CommonUtil::getDescByValue('answer', 'status', $v['answer']['status'])?>
						    	</span>
						  <?php if($v['task']['status']==2){?>
						 <?php if($v['task']['count_done']>=$v['task']['number']){?>
						 <span class=" pull-right"><span >任务已满额</span>
    						  <?php if($v['answer']['status']==1){?>
    						 <span class="btn btn-warning del-answer"  answerid="<?= $v['answer']['id']?>">删除</span></span>
    						 <?php }?>
						 <?php }elseif($v['answer']['status']==1){?>
        					<?php if($v['task']['dist']*30<=$v['task']['do_radius']){?>
        					<a class="btn  btn-warning pull-right do-task"  task_guid="<?= $v['task']['task_guid']?>"  answer_guid="<?= $v['answer']['answer_guid']?>"> 做任务</a>
        				    <?php  }else {?>
        				     <span class=" pull-right"> <span >不在执行范围</span>
        				     <span class="btn btn-warning del-answer" answerid="<?= $v['answer']['id']?>">删除</span></span>
        				    <?php }?>
				    <?php } }else {?>
        				    <?php if($v['answer']['status']==1){?>
            						 <span class="btn btn-warning del-answer"  answerid="<?= $v['answer']['id']?>">删除</span></span>
            						 <?php }?>
				    <?php }?>
				</p>
				</li>
			</ul>
			     
<?php } }?>