<?php
use common\models\CommonUtil;
use common\models\UserOperation;
use yii\widgets\LinkPager;
use yii\helpers\Url;
$this->title="我的消息";
$this->params['breadcrumbs'][] = ['label'=>'个人中心','url'=>'view'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-box">
                  <aside class="sm-side">
                      <div class="user-head">
                          <a href="javascript:;" class="inbox-avatar">
                          <?php if(empty(yii::$app->user->identity->img_path)){?>
                           <img src="<?= yii::getAlias('@avatar')?>/unknown.jpg" class="img-responsive " alt=" ">
                         <?php } else {?>                                 
                        <img src="<?= yii::getAlias('@avatar').'/'.yii::$app->user->identity->img_path;?>" class="img-responsive ">
                         <?php }?>
                          </a>
                          <div class="user-name">
                              <h5><a href="#"><?= yii::$app->user->identity->real_name?></a></h5>
                              <span><a href="#"><?= yii::$app->user->identity->email?></a></span>
                          </div>                     
                      </div>
               
                      <ul class="inbox-nav inbox-divider">
                          <li class="active">
                              <a href="<?= Url::to('message')?>"><i class="icon-inbox"></i> 收件箱 <span class="label label-default pull-right" id="totalNum"><?php if($totalNum>0) echo $totalNum?></span></a>

                          </li>
                          <li>
                              <a href="<?= Url::to('message')?>?state=unread"><i class="icon-envelope-alt"></i> 未读消息 <span class="label label-danger pull-right" id="unreadNum"><?php if($unReadNum>0) echo $unReadNum?></span></a>
                          </li>
                          <li>
                              <a href="<?= Url::to('message')?>?state=readed"><i class="icon-bookmark-empty"></i> 已读消息 <span class="label label-info pull-right" id="isreadNum"><?php if($isReadNum>0) echo $isReadNum?></span></a>
                          </li>
                    
                             
                      </ul>
                    
                                  

                  </aside>
                  <aside class="lg-side">
                      <div class="inbox-head">
                          <h4>收件箱</h4>
                        
                      </div>
                      <div class="inbox-body">
                         <div class="mail-option">
                           <!--  <div class="chk-all">
                                 <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                 <div class="btn-group" >
                                     <a class="btn mini all" href="#" data-toggle="dropdown">
                                         全选
                                         <i class="icon-angle-down "></i>
                                     </a>
                                     <ul class="dropdown-menu">
                                         <li><a href="#"> 反选</a></li>
                                         <li><a href="#"> 已读</a></li>
                                         <li><a href="#"> 未读</a></li>
                                     </ul>
                                 </div>
                             </div>

                             <div class="btn-group">
                                 <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="刷新">
                                     <i class=" icon-refresh"></i>
                                 </a>
                             </div>
                             <div class="btn-group hidden-phone">
                                 <a class="btn mini blue" href="#" data-toggle="dropdown">
                                    更多操作
                                     <i class="icon-angle-down "></i>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <li><a href="#"><i class="icon-pencil"></i> 标记为已读</a></li>                               
                                     <li class="divider"></li>
                                     <li><a href="#"><i class="icon-trash"></i> 删除</a></li>
                                 </ul>
                             </div>         -->               

                             <div class="pull-right">
                                <?= LinkPager::widget(['pagination' => $messagePages]); ?>
                             </div>
                         </div>
                   <div class="panel-group" id="accordion">
                         <?php foreach ($messageModel as $k=>$v){?>
                      <div class="panel panel-default">
                        <div class="panel-heading <?php if($v['is_read']==0) echo "unread"?>">
                          <h4 class="panel-title">
                          <input type="checkbox" class="mail-checkbox">
                            <a data-toggle="collapse" data-parent="#accordion" 
                              href="#collapse<?= $k?>" class="check-message" message_guid="<?= $v['message_guid']?>">                              
                              <?= $v['title']?>
                              <span class="pull-right"><?php if($v['type']==CommonUtil::SYS_MESSAGE) {echo "系统消息";}
                              else {echo UserOperation::searchDownUser($v['from_user']);}
                              ?>&nbsp;&nbsp;&nbsp; &nbsp; <?= CommonUtil::fomatTime($v['insert_time'])?></span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse<?= $k?>" class="panel-collapse collapse ">
                          <div class="panel-body message-content">
                             <p><?= $v['content']?></p>
                             <p class="pull-right "><?= CommonUtil::fomatTime($v['insert_time'])?></p>
                          </div>
                        </div>
                      </div>
                      
                      <?php }?>
                     
                    </div>

                      </div>
                  </aside>
              </div>
             <script>
             $('.check-message').click(function(){
           	  var that=$(this);
                  	         
           	  if( that.parent().parent().hasClass('unread')){
           	 	  that.parent().parent().removeClass('unread');
           	 	  var message_guid=that.attr('message_guid');
           	 	  $.ajax({
               	 	  url:"<?= yii::$app->urlManager->createUrl('profile/message-read')?>",
              	     data:{
                	       message_guid:message_guid
              	     },
               	    method:"POST",
               	    success:function(response){
                 		  var unreadNum=parseInt($('#unreadNum').text())-1;   
                 	
                       	  if(unreadNum<1){
                         		$('#unreadNum').text('');
                       	  }else if(unreadNum>0){
                         		$('#unreadNum').text(unreadNum);
                       	  }
                       	  var isreadNum=parseInt($('#isreadNum').text())+1;           
                       	  if(isreadNum<1){
                         		$('#isreadNum').text('');
                       	  }else if(isreadNum>0){
                         		$('#isreadNum').text(isreadNum);
                       	  }
               	    },
               	    error:function(error){
                  	     alert('出现错误='+error.status);
               	    }

           	 	  });
           	  }
           	  
             });

             </script>