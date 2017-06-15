<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\CommonUtil;
use common\models\SMS;
use common\models\MobileVerify;
use common\models\Shop;
use common\models\Order;
use common\models\LoginRec;
use common\models\Task;
use yii\db\Exception;
use common\models\Answer;
use common\models\Question;
use common\models\AnswerDetail;
use common\models\ImageUploader;
use yii\data\ActiveDataProvider;
use common\models\Template;
use common\models\Wallet;
use common\models\GroupUser;
use yii\web\UploadedFile;


/**
 * app api
 */
class TaskController extends Controller
{
 

    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
    
    public function beforeAction($action){

           //检查客户端是否提交数据
            if(!isset($_POST['data'])){
                return CommonUtil::error('e1001');
            }
            
      //检查用户是否登录
            if(!isset($_POST['user'])){
                return CommonUtil::error('e1001');
            }
    
        
        return parent::beforeAction($action);
    }
    
  
        
    /**
     * 获取任务列表
     */
    public function  actionGetTaskList(){
        //更新任务状态
        $now=time();
        Task::updateAll(['status'=>3]," end_time < $now ");
        
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $page=@$_POST['data']['page'];
        $lat = @$_POST['data']['locInfo']['lat']*3600*256;
        $lng = @$_POST['data']['locInfo']['lng']*3600*256;
      
        $lnglat = $lng." ".$lat;
        $start=intval(($page-1)*10);  
        $type=0; 
        $type=@$_POST['data']['type'];  
        $order=@$_POST['data']['order'];
        $keyword=@$_POST['data']['keyword'];
        $where="";
        $orders="ORDER BY dist ASC";
        
        switch ($type){
            case 0:
                $where="";
                break;
            case 1:
                $where=" and type=1 ";
                break;
            case 2:
                $where=" and type=2 ";
                break;
            case 3:
                $where=" and type=3 ";
                break;
            case 4:
                $where=" and type=4 ";
                break;
            case 7://宅在家
                    $where=" and do_type=1 ";
                    break;
            case 8://四处跑
                   $where=" and do_type=2 ";
                        break;
            case 9://推荐任务
                $where=" and is_recommend=1 ";
                break;
        }
        
        $groupUser=GroupUser::findAll(['user_guid'=>$user->user_guid]);
        if(empty($groupUser)){
            $where .=" and group_id = 0 ";
        }else {
            $groups=[];
            foreach ($groupUser as $k=> $v){
                $groups[]=$v->group_id;
            }
            $groups=implode(',', $groups);
            $where .=" and (group_id in ($groups) or group_id =0) ";
        }
        
        if(!empty($keyword)){
            $where .=" and (name like '%$keyword%' or province like '%$keyword%' or city like '%$keyword%' or address like '%$keyword%')";
        }
        
        switch ($order){
            case  0:
                break;
            case 1:
                $orders="order by price desc";//酬劳最高
                break;
            case 2:
                $orders="order by dist asc";//离我最近
                break;
            case 3:
                $orders="order by created_at desc";//最新上线
                break;
        }
        
      	$cmdStr = "
			SELECT *,ST_Distance(lnglat, ST_GeomFromText('POINT($lnglat)', 26910))/256 dist
			FROM task WHERE ST_DWithin(lnglat,ST_GeomFromText('POINT($lnglat)', 26910),radius*256/30) and status=2 and number >count_done $where $orders LIMIT 10 OFFSET $start;";
        $taskList=yii::$app->db->createCommand($cmdStr)->queryAll();
        if(empty($taskList)){
            return "nodata";
        }
 
        return $this->renderAjax('task-list',[
                  'taskList'=>$taskList
        ]);
        
    }
    
    /**
     * 获取任务列表
     */
    public function  actionGetMaptaskList(){
       
    
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $lat = @$_POST['data']['locInfo']['lat']*3600*256;
        $lng = @$_POST['data']['locInfo']['lng']*3600*256;
    
        $lnglat = $lng." ".$lat;
       
        $cmdStr = "
        SELECT *,ST_Distance(lnglat, ST_GeomFromText('POINT($lnglat)', 26910))/256 dist
        FROM task WHERE ST_DWithin(lnglat,ST_GeomFromText('POINT($lnglat)', 26910),radius*256/30) and status=2 and number >count_done order by dist asc LIMIT 500;";
        $taskList=yii::$app->db->createCommand($cmdStr)->queryAll();
      
        $data=[];
        foreach ($taskList as $k=>$v){
            $img="";
            if(!empty($v['photo'])){
                $img="<img class='mui-media-object mui-pull-left' src='". yii::getAlias('@photo').'/'.@$v['path'].'thumb/'.@$v['photo']."' />";
            }
            $price=($v['is_show_price']==1)?"<p><span > <span class='orange'>￥ ".@$v['price']."/ 单</span></span></p>":"";
            $content="<ul class='mui-table-view' style='padding:5px'>
				<li class='mui-media task-list'  task_guid='". @$v['task_guid']."' >".$img.
						"<div class='mui-media-body'>
							<b class='mui-ellipsis'>".@$v['name']."</b>".
							  $price
							    ."<p>
								<span class='sub'>剩余 : ".intval(@$v['number']-@$v['count_done'])."</span>
							</p>
							<p>
								<span class='sub'>截止 : ".CommonUtil::fomatDate(@$v['end_time'])."</span>
								<span class='pull-right'>
								</span>
							</p>
							<p >
								<span style='font-size: 12px;'>地址:". @$v['address']."(" . sprintf("%.2f",(@$v['dist']*30)/1000)."km）</span>
							</p>
							<p><a  href='../task-detail.html?task_guid=".@$v['task_guid']."' >查看详情</a></p>
						</div>
				</li>
			</ul>";
            $data[$k]=[@$v['lng'],@$v['lat'],$content];
        }
        
        return CommonUtil::success($data);
    
    }
    
    
    
    /**
     * 获取任务列表
     */
    public function  actionGetRecommendTask(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $lat = @$_POST['data']['locInfo']['lat']*3600*256;
        $lng = @$_POST['data']['locInfo']['lng']*3600*256;
        $lnglat = $lng." ".$lat;
        
         $where =" and group_id = 0 ";
        $groupUser=GroupUser::findAll(['user_guid'=>$user->user_guid]);
        if(!empty($groupUser)){
          
            $groups=[];
            foreach ($groupUser as $k=> $v){
                $groups[]=$v->group_id;
            }
            $groups=implode(',', $groups);
            $where =" and (group_id in ($groups) or group_id=0) ";
        }
        
        $cmdStr = "
        SELECT *,ST_Distance(lnglat, ST_GeomFromText('POINT($lnglat)', 26910))/256 dist
        FROM task WHERE ST_DWithin(lnglat,ST_GeomFromText('POINT($lnglat)', 26910),radius*256/30)  and status=2 and is_recommend=1 and number >count_done $where ORDER BY dist ASC,created_at desc LIMIT 20 ;";
        $taskList=yii::$app->db->createCommand($cmdStr)->queryAll();
        if(empty($taskList)){
            return "<p>您周围没有推荐任务哦！</p>";
        }
    
        return $this->renderAjax('recommend-task-list',[
            'taskList'=>$taskList
        ]);
    
    }
    
    /**
     * 领取任务
     */
    public function  actionGetTask(){
        
        
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        
//         $answer=Answer::findOne(['task_guid'=>$data['task_guid'],'user_guid'=>$user->user_guid]);
//          if(!empty($answer)){
 //       return CommonUtil::success('has-getted');
//          }
         
        $task_guid=$data['task_guid'];
        
        $task=Task::findOne(['task_guid'=>$data['task_guid']]);
        
        $countAnswer=Answer::find()->andWhere(['task_guid'=>$data['task_guid'],'user_guid'=>$user->user_guid])->count();
        if($countAnswer>=$task->max_times){
            return CommonUtil::success('has-getted');
        }
        
        //面任务
        if($task->answer_type==2){
            $lat = @$_POST['data']['locInfo']['lat']*3600*256;
            $lng = @$_POST['data']['locInfo']['lng']*3600*256;
            $lnglat = $lng." ".$lat;
            $answerRadius=$task->answer_radius;
            $answerRadius=$answerRadius*256/30;
            $cmdStr = "
            SELECT *  FROM answer  WHERE ST_DWithin(submit_lnglat,ST_GeomFromText('POINT($lnglat)', 26910),$answerRadius) and task_guid='$task_guid' and status=2";
            $taskArr=yii::$app->db->createCommand($cmdStr)->queryAll();
            if(!empty($taskArr)){
                return CommonUtil::success('dist-limit');
            }
        }
        
        $transaction=yii::$app->db->beginTransaction();
        try{
            $answer=new Answer();
            $answer->answer_guid=CommonUtil::createUuid();
            $answer->task_guid=$task->task_guid;
            $answer->user_guid=$user->user_guid;
            $answer->start_lng=@$data['locInfo']['lng'];
            $answer->start_lat=@$data['locInfo']['lat'];
            $answer->start_address=@$data['locInfo']['address'];
            $answer->start_time=time();
            $answer->status=1;
            $answer->start_lnglat=CommonUtil::getGeomLnglat($answer->start_lng, $answer->start_lat);
            $answer->created_at=time();
            if (!$answer->save()) throw new Exception();
            
            $task->count_get+=1;
            $task->updated_at=time();
            if(!$task->save()) throw new Exception();
            $transaction->commit();
            return CommonUtil::success($task);
        }catch (Exception $e){
            $transaction->rollBack();
            return CommonUtil::error('e1002');
        }
        
    }
    
    /**
     * 获取任务列表
     */
    public function  actionMyTask(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        
        $page=$_POST['data']['page'];
        $status=$_POST['data']['status'];
        $offset=($page-1)*50;
        $page=$page*50;
        if($status=='100'){
            $myTask=Answer::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->offset($offset)->limit($page)->all();
        }else{
        $myTask=Answer::find()->andWhere(['user_guid'=>$user->user_guid,'status'=>$status])->orderBy('created_at desc')->offset($offset)->limit($page)->all();
        }
        if(empty($myTask)){
            return 'nodata';
        }
        $lat = @$_POST['data']['locInfo']['lat']*3600*256;
        $lng = @$_POST['data']['locInfo']['lng']*3600*256;
       
        $lnglat = $lng." ".$lat;
        $taskArr=array();
        foreach ($myTask as $v){
            $task_guid=$v->task_guid;
            $cmdStr = "
            SELECT *,ST_Distance(lnglat, ST_GeomFromText('POINT($lnglat)', 26910))/256 dist
            FROM task WHERE task_guid='$task_guid' order by created_at desc;";
            $taskArr[]=[
                'task'=>  yii::$app->db->createCommand($cmdStr)->queryOne(),
                'answer'=>$v
            ];
        }
    
        return $this->renderAjax('my-task',[
            'taskArr'=>$taskArr
        ]);
    
    }
    
    
    

    /**
     * 获取任务详情
     */
    public function  actionTaskInfo(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }

        $lat = @$_POST['data']['locInfo']['lat']*3600*256;
        $lng = @$_POST['data']['locInfo']['lng']*3600*256;
         
        $lnglat = $lng." ".$lat;
      
            $task_guid=$_POST['data']['task_guid'];
            $cmdStr = "
            SELECT *,ST_Distance(lnglat, ST_GeomFromText('POINT($lnglat)', 26910))/256 dist
            FROM task WHERE task_guid='$task_guid' order by created_at desc;";
            $taskArr=yii::$app->db->createCommand($cmdStr)->queryOne();
            
            $answerCount=Answer::find()->andWhere(['task_guid'=>$task_guid,'user_guid'=>$user->user_guid])->count();
    
        return $this->renderAjax('task-info',[
            'taskArr'=>$taskArr,
            'answerCount'=>$answerCount
        ]);
    
    }
    
    /**
     * 获取任务问卷
     */
    public function  actionTaskQuestion(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $task_guid=$_POST['data']['task_guid'];
        $task=Task::findOne(['task_guid'=>$task_guid]);
        
        //面任务
        if($task->answer_type==2){
            $lat = @$_POST['data']['locInfo']['lat']*3600*256;
            $lng = @$_POST['data']['locInfo']['lng']*3600*256;
            $lnglat = $lng." ".$lat;
            $answerRadius=$task->answer_radius;
            $answerRadius=$answerRadius*256/30;
            $cmdStr = "
            SELECT *  FROM answer  WHERE ST_DWithin(submit_lnglat,ST_GeomFromText('POINT($lnglat)', 26910),$answerRadius) and task_guid='$task_guid' and status=2";
            $taskArr=yii::$app->db->createCommand($cmdStr)->queryOne();
            if(!empty($taskArr)&&$taskArr['user_guid']!=$user->user_guid){
                return 'dist-limit';
            }
        }
        
        $answer=Answer::findOne([ 'answer_guid'=>@$data['answer_guid'],'task_guid'=>$task_guid,'user_guid'=>$user->user_guid]);
        if(!empty($answer)&&empty($answer->answer_time)){
            $answer->answer_time=time();
            $answer->answer_address=@$_POST['data']['locInfo']['address'];
            $answer->save();
        }
        
        
        $question=Question::find()->andWhere(['task_guid'=>$task_guid])->orderBy('code asc')->all();
//         foreach ($question as $k=>$v){
//             if($v['type']==0){
               
//                 $options=json_decode($v['options'],true);
//                 foreach ($options as $option){
//                     if(!empty($option['link'])&&!empty($v['code'])){
//                         $link=$option['link'];
//                         for($i=($v['code']+1);$i<$link;$i++){//被跳过的题目为非必答题
//                             Question::updateAll(['required'=>0],['task_guid'=>$task_guid,'code'=>$i]);
//                         }
//                     }
                    
//                     if(!empty($option['refer'])){//被引用的题目也为非必答题
//                         Question::updateAll(['required'=>0,'refered'=>1],['task_guid'=>$task_guid,'code'=>$option['refer']]);
//                     }
//                 }
//             }
//         }
        
        $count=count($question);
        return $this->renderAjax('task-question',[
            'question'=>$question,    
            'count'=>$count,
            'task'=>$task,
            'answer'=>$answer
        ]);
    
    }
    
    /**
     * 删除已领取任务
     */
    public function  actionDelAnswer(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
    
        $answerid=@$_POST['data']['answerid'];
        if(!empty($answerid)){
            Answer::deleteAll(['id'=>$answerid]);
            return CommonUtil::success('删除成功!');
        }
       
        return CommonUtil::error('e1002');
      
    }
    

    
    /**
     * 提交任务答案
     */
    public function  actionSubmitAnswer(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $locInfo=$_POST['locInfo'];
        $task_guid=$_POST['task_guid'];
        foreach ($data as $v){
            $type=$v['type'];
           if ($type==3){
                $answerDetail=AnswerDetail::findOne(['answer_guid'=>@$v['answer_guid'],'task_guid'=>$v['task_guid'],'user_guid'=>$user->user_guid,'question_guid'=>$v['question_guid'],'answer'=>$v['imageIndex']]);
            }else{
                $answerDetail=AnswerDetail::findOne(['answer_guid'=>@$v['answer_guid'],'task_guid'=>$v['task_guid'],'user_guid'=>$user->user_guid,'question_guid'=>$v['question_guid']]);
            }
            
            if(empty($answerDetail)){
                $answerDetail=new AnswerDetail();
                $answerDetail->created_at=time();
            }else{
                $answerDetail->updated_at=time();
            }
            $answer=Answer::findOne(['answer_guid'=>@$v['answer_guid'],'task_guid'=>$task_guid,'user_guid'=>$user->user_guid]);

            if(empty($answer)){
                return CommonUtil::error('e1002');
            }

            $answerDetail->answer_guid=@$answer->answer_guid;
            $answerDetail->task_guid=$v['task_guid'];
            $answerDetail->user_guid=$user->user_guid;
            $answerDetail->question_guid=$v['question_guid'];
            $answerDetail->type=$type;
            if(!empty($v['answer_time'])){
                $answer_time=$v['answer_time'];
                $len=strlen($answer_time);
                $answerDetail->answer_time=substr($answer_time, 0,$len-3);
            }
            $answerDetail->answer_address=@$v['answer_address']['address'];
            $answerDetail->code=$v['code'];
            if($type==0){//单选题
                $answerDetail->answer=$v['answer'];
                $answerDetail->open_answer=@$v['open_answer'];
            }elseif($type==2 ||$type==6 ||$type==7){
                $answerDetail->answer=$v['answer'];
            }elseif ($type==1){
                $answerDetail->answer=json_encode($v['answer'],JSON_UNESCAPED_UNICODE);
            }elseif($type==3){
                $waterMaskStr= $answerDetail->answer_address;
                if(empty($waterMaskStr)){
                    $waterMaskStr=@$locInfo['address'];
                }
                if(empty($answerDetail->answer_time)){
                    $answerDetail->answer_time=time();
                } 
         
                $photo=ImageUploader::uploadImageByBase64($v['answer'][0]['imgData'], $v['answer'][0]['imgLen'],$waterMaskStr,$answerDetail->answer_time);
                if($photo){
                    $answerDetail->path=$photo['path'];
                    $answerDetail->photo=$photo['photo'];
                    $answerDetail->answer=$v['imageIndex'];
                } 
            }
           
            $answerDetail->save();                      
        }
   
        $answer->submit_lng=@$locInfo['lng'];
        $answer->submit_lat=@$locInfo['lat'];
        $answer->submit_address=@$locInfo['address']; 
        $answer->end_time=time();
        $answer->status=2;
         $answer->submit_lnglat=CommonUtil::getGeomLnglat($answer->submit_lng, $answer->submit_lat);
         $answer->updated_at=time();
        if($answer->save()){
            $task=Task::findOne(['task_guid'=>$task_guid]);
            $task->count_done+=1;
            if($task->count_done>$task->number){
                $task->count_done=$task->number;
            }
            $task->count_answer+=1;
            $task->latest_submit_time=time();
            $task->save();
            return CommonUtil::success('success');
        }
        
        return CommonUtil::error('e1002');
        
    }
    
    //离线保存答案
    public function  actionOfflineSaveAnswer(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
         
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $locInfo=$_POST['locInfo'];
        $answer_guid=$_POST['answer_guid'];
        $answer=Answer::findOne(['answer_guid'=>$answer_guid]);
        $answer->offline_save=1;
        $answer->save_lng=@$locInfo['lng'];
        $answer->save_lat=@$locInfo['lat'];
        $answer->save_address=@$locInfo['address'];
        $answer->save_time=time();
        if($answer->save()){
            return CommonUtil::success('success');
        }
        return CommonUtil::error('e1002');
    }
    /**
     * 接收音频文件
     */
    public function  actionUploadAudio(){
        $clientUser=$_POST['user'];
        $clientUser=json_decode($clientUser,true);
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
         
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        

       $audioFiles=UploadedFile::getInstancesByName('audio');
        if(empty($audioFiles)){
            return false;
        }
            $basePath='../../upload/photo/';
            $path=date('Ymd').'/';
            if(!is_dir($basePath.$path)){
                mkdir($basePath.$path);
            }
        $fileName=date('YmdHis').rand(0000, 9999).'.'.$audioFiles[0]->extension;
        $audioFiles[0]->saveAs($basePath.$path.$fileName);
        
        
        $task_guid=$_POST['task_guid'];
        $answer_guid=$_POST['answer_guid'];
        $question_guid=$_POST['question_guid'];
        $code=$_POST['code'];
        $loc=@$_POST['loc'];
            
          $answerDetail=AnswerDetail::findOne(['answer_guid'=>$answer_guid,'task_guid'=>$task_guid,'user_guid'=>$user->user_guid,'question_guid'=>$question_guid]);
            
            if(empty($answerDetail)){
                $answerDetail=new AnswerDetail();
                $answerDetail->created_at=time();
            }else{
                $answerDetail->updated_at=time();
            }
            $answer=Answer::findOne(['answer_guid'=>$answer_guid,'task_guid'=>$task_guid,'user_guid'=>$user->user_guid]);
    
            if(empty($answer)){
                return CommonUtil::error('e1002');
            }
    
            $answerDetail->answer_guid=@$answer->answer_guid;
            $answerDetail->task_guid=$task_guid;
            $answerDetail->user_guid=$user->user_guid;
            $answerDetail->question_guid=$question_guid;
            $answerDetail->path=$path;
            $answerDetail->photo=$fileName;
            $answerDetail->type=4;
            $answerDetail->code=$code;
            $answerDetail->answer_address=@$loc['address'];
            $answerDetail->answer_time=time();
            $answerDetail->save();
         
       
            return CommonUtil::success('success');
    
    
    }
    
    
    

}
