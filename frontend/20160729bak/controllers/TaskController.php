<?php

namespace frontend\Controllers;

use Yii;
use common\models\Task;
use common\models\SearchTask;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CommonUtil;
use common\models\Question;
use yii\data\ActiveDataProvider;
use common\models\GeoCoding;
use common\models\ImageUploader;
use common\models\Group;
use common\models\Answer;
use yii\filters\AccessControl;
use common\models\AnswerDetail;
use common\models\Message;
use yii\db\Exception;
use common\models\IncomeRec;
use common\models\Wallet;
use common\models\Template;
use common\models\TemplateQuestion;
use common\models\TaskTemplate;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view-answer-photo'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     *全部任务
     * @return mixed
     */
    public function actionIndex()
    {
        $user_guid=yii::$app->user->identity->user_guid;
        $searchModel = new SearchTask();
        $searchModel->post_type=2;
        $searchModel->user_guid=$user_guid;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     *平台任务
     * @return mixed
     */
    public function actionAdminTask()
    {
        $searchModel = new SearchTask();
        $searchModel->post_type=1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     *第三方任务
     * @return mixed
     */
    public function actionSpTask()
    {
        $user_guid=yii::$app->user->identity->user_guid;
        $searchModel = new SearchTask();
        $searchModel->post_type=2;
        $searchModel->user_guid=$user_guid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $question=Question::findOne(['task_guid'=>$model->task_guid]);
        if(!empty($question)&&empty($question->code)){
            $questionArr=Question::find()->andWhere(['task_guid'=>$model->task_guid])->all();
            foreach ($questionArr as $k=> $v){
                Question::updateAll(['code'=>$k+1],['question_guid'=>$v['question_guid']]);
            }
        }
        $dataProvider=new ActiveDataProvider([
            'query'=>Question::find()->andWhere(['task_guid'=>$model->task_guid])->orderBy('code asc'),
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider
        ]);
    }
    
    public function actionOffLine($id){
        Task::updateAll(['status'=>3],['id'=>$id]);
        yii::$app->getSession()->setFlash('success','下线成功!');
        return $this->redirect(yii::$app->request->referrer);
    
    }
    
    /**
     * 选择模板
     * @param unknown $id
     * @return Ambigous <string, string>
     */
    public function actionChooseTemplate($id){
       $model=Task::findOne($id);
        $dataProvider=new ActiveDataProvider([
            'query'=>Template::find()->orderBy('created_at desc'),
        ]);
    
        return $this->render('choose-template',[
            'model'=>$model,
            'dataProvider'=>$dataProvider
        ]);
    }
    
    public function actionChooseTemplateDo(){
        $task_id=$_POST['task_id'];
        $task=Task::findOne($task_id);
        $templateid=$_POST['templateid'];
        $template=Template::findOne($templateid);
        $baseCode=Question::find()->andWhere(['task_guid'=>$task->task_guid])->max('code');
        $templateQuestion=TemplateQuestion::findAll(['templateno'=>$template->templateno]);
        foreach ($templateQuestion as $k=>$v){
            $question=new Question();
            $question->task_guid=$task->task_guid;
            $question->question_guid=CommonUtil::createUuid();
            $question->name=$v->name;
            $question->desc=$v->desc;
            $question->type=$v->type;
            $question->code=intval($baseCode+$v->code);
            $question->options=$v->options;
            $question->qrcode_value=$v->qrcode_value;
            $question->max_photo=$v->max_photo;
            $question->required=$v->required;
            $question->created_at=time();
            $question->save();
        }
        
        yii::$app->getSession()->setFlash('success','模板选择成功!');
        return $this->redirect(['view','id'=>$task_id]);
    }
    
    public function actionViewAnswer($id){
        $model=$this->findModel($id);
        $where="";
        $status=0;
        if(isset($_GET['status'])){
            $status=$_GET['status'];
        }
        
        if ($status!=0){
            $where=" status=$status";
        }
        
        $dataProvider=new ActiveDataProvider([
            'query'=>Answer::find()->andWhere(['task_guid'=>$model->task_guid])->andWhere($where)->orderBy('created_at desc'),
        ]);
        $this->layout="@app/views/layouts/taskanswer_layout.php";
        return $this->render('view-answer', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ]);
    }
    
/*     public function actionViewAnswerDetail($id){
        $model=Answer::findOne($id);
        $answerDetail=AnswerDetail::find()->andWhere(['task_guid'=>$model->task_guid,'user_guid'=>$model->user_guid])
        ->distinct('code')->orderBy('code asc')->all();
        return $this->render('view-answer-detail', [
            'model' => $model,
            'answerDetail'=>$answerDetail
        ]);
    } */
    
    public function actionViewAnswerDetail($id){
        $model=Answer::findOne($id);
        $question=Question::find()->andWhere(['task_guid'=>$model->task_guid])
        ->orderBy('code asc')->all();
        return $this->render('view-answer-detail', [
            'model' => $model,
            'question'=>$question
        ]);
    }
    
    public function actionViewAnswerPhoto($task_guid,$question_guid,$user_guid){
        if(!empty($_GET['answer_guid'])){
            $answer_guid=$_GET['answer_guid'];
            $answerDetail=AnswerDetail::find()->andWhere(['answer_guid'=>$answer_guid,'task_guid'=>$task_guid,'question_guid'=>$question_guid,'user_guid'=>$user_guid])->orderBy('answer asc')->all();
        }else{
            $answerDetail=AnswerDetail::find()->andWhere(['task_guid'=>$task_guid,'question_guid'=>$question_guid,'user_guid'=>$user_guid])->orderBy('answer asc')->all();
        }
      
        return $this->renderPartial('view-answer-photo',[
            'answerDetail'=>$answerDetail
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        if(isset($_GET['project_id'])){
            $model->project_id=$_GET['project_id'];
        }
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->task_guid=CommonUtil::createUuid();
            $model->total_price=$model->price*$model->number;
            $model->user_guid=yii::$app->user->identity->user_guid;
            $model->end_time=strtotime($model->end_time);
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            if(empty($model->group_id)){
                $model->group_id=0;
            }
            $model->post_type=2;
            $model->desc=@$_POST['desc'];
            $model->created_at=time();
            $address=$model->address;
            //地址转经纬度
            $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
            $result=$geoCoding->getLngLatFromAddress(urldecode($address));
            if($result['status']==0){
                $model->lng=$result['result']['location']['lng'];
                $model->lat=$result['result']['location']['lat'];
                $model->lnglat=CommonUtil::getGeomLnglat($model->lng, $model->lat);
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                yii::$app->getSession()->setFlash('error','任务创建失败!');
            }
            
         
        } else {
            $group=Group::find()->andWhere(['create_by'=>yii::$app->user->identity->user_guid])->all();
            return $this->render('create', [
                'model' => $model,
                'group'=>$group
            ]);
        }
    }
    
    public function actionPost($id){
        $model=Task::findOne($id);
        $model->status=1;
        $model->updated_at=time();
        if($model->save()){
            yii::$app->getSession()->setFlash('success','发布成功,请等待管理员审核!');
        }else{
            yii::$app->getSession()->setFlash('error','发布失败,请稍候重试!');
        }
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionRecommend($id){
        $model=Task::findOne($id);
        if($model->is_recommend==0){
            $model->is_recommend=1;
            $model->updated_at=time();
            if($model->save()){
                yii::$app->getSession()->setFlash('success',$model->name.'-推荐成功!');
                }else{
                    yii::$app->getSession()->setFlash('error',$model->name.'-推荐失败,请稍候重试!');
                }
        }elseif ($model->is_recommend==1){
            $model->is_recommend=0;
            $model->updated_at=time();
            if($model->save()){
                yii::$app->getSession()->setFlash('success',$model->name.'-取消推荐成功!');
                }else{
                    yii::$app->getSession()->setFlash('error',$model->name.'-取消推荐失败,请稍候重试!');
                }
        }
        
                return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionAuthPass($id){
        $model=Task::findOne($id);
        
        if($model->status==1||$model->status==99){
            $model->status=2;
            $model->updated_at=time();
            if($model->save()){
                yii::$app->getSession()->setFlash('success',$model->name.'-审核成功!');
            }else{
                yii::$app->getSession()->setFlash('error',$model->name.'-审核失败,请稍候重试!');
            }
        }
        
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionAuthDeny($id){
        $model=Task::findOne($id);
    
        if($model->status==1){
            $model->status=99;
            $model->updated_at=time();
            if($model->save()){
                yii::$app->getSession()->setFlash('success',$model->name.'-审核未通过!');
            }else{
                yii::$app->getSession()->setFlash('error',$model->name.'-操作失败,请稍候重试!');
            }
        }
    
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionAddQuestion(){
        $task_guid=$_POST['task_guid'];
 
        $required=@$_POST['required'];
      
        $code=Question::find()->andWhere(['task_guid'=>$task_guid])->max('code');
        $code+=1;
        $name=$_POST['name'];
        $type=$_POST['type'];
        $options=array();
        if($type==0){
            $optArr=$_POST['optArr'];
            $link=$_POST['link'];
            $open=$_POST['open'];
            $refer=$_POST['refer'];
            $i=0;
            foreach ($optArr as $v){
                if(empty($v)){
                    continue;
                }
                $options[]=[
                    'opt'=>$v,
                    'link'=>$link[$i],
                    'open'=>$open[$i],
                    'refer'=>$refer[$i],
                ];
                $i++;
            }
        }elseif ($type==1){
            $optArrMulti=$_POST['optArrMulti'];
            foreach ($optArrMulti as $v){
                if(empty($v)){
                    continue;
                }
                $options[]=$v;
            }
        }elseif ($type==7){
            $options=[
                'min'=>@$_POST['minnum'],
                'max'=>@$_POST['maxnum']
            ];
        }
        
        $question=new Question();
        $question->task_guid=$task_guid;
        $question->user_guid=yii::$app->user->identity->user_guid;
        $question->question_guid=CommonUtil::createUuid();
        $question->type=$type;
        $question->name=$name;
        $question->code=$code;
        if($required==1){
            $question->required=1;
        }
        if($type==0 || $type==1 ||$type==7){
            $question->options=json_encode($options);
        }elseif ($type==5){
            $question->qrcode_value=$_POST['qrcode-value'];
        }elseif ($type==3){
            $question->max_photo=$_POST['imgnum'];
        }
        
        $question->created_at=time();
        if($question->save()){
            yii::$app->getSession()->setFlash('success','问题增加成功');
        }else{
            yii::$app->getSession()->setFlash('error','问题增加失败');
        }
        return $this->redirect(yii::$app->request->referrer);
        
    }
    
    public function actionUpdateQuestionDo(){
        $task_guid=$_POST['task_guid'];
        $task=Task::findOne(['task_guid'=>$task_guid]);
        $required=@$_POST['required'];
        $question_guid=$_POST['question_guid'];
        $question=Question::findOne(['task_guid'=>$task_guid,'question_guid'=>$question_guid]);
        $type=$question->type;
        $name=$_POST['name'];
        $options=array();
        if($type==0){
            $optArr=$_POST['optArr'];
                $link=$_POST['link'];
                $open=$_POST['open'];
                $refer=$_POST['refer'];
                $i=0;
                foreach ($optArr as $v){
                    if(empty($v)){
                        continue;
                    }
                    $options[]=[
                        'opt'=>$v,
                        'link'=>$link[$i],
                        'open'=>$open[$i],
                        'refer'=>$refer[$i],
                    ];
                    $i++;
                }
            }elseif ($type==1){
            $optArrMulti=$_POST['optArrMulti'];
                foreach ($optArrMulti as $v){
                   if(empty($v)){
                        continue;
                    }
                $options[]=$v;
                }
          }elseif ($type==7){
            $options=[
                'min'=>@$_POST['minnum'],
                'max'=>@$_POST['maxnum']
            ];
        }
                
                if($required==1){
                    $question->required=1;
                }
                $question->name=$name;
                  if($type==0 || $type==1 ||$type==7){
                        $question->options=json_encode($options);
                    }elseif ($type==5){
                        $question->qrcode_value=$_POST['qrcode-value'];
                    }elseif ($type==3){
                        $question->max_photo=$_POST['imgnum'];
                    }
    
                $question->updated_at=time();
                if($question->save()){
                    yii::$app->getSession()->setFlash('success','问题修改成功');
                }else{
                    yii::$app->getSession()->setFlash('error','问题修改失败');
                }
                return $this->redirect(['view','id'=>$task->id]);
    
    }
    
    //删除问题
    public function actionDeleteQuestion($id){
        $question=Question::findOne($id)->delete();
        yii::$app->getSession()->setFlash('success','问题删除成功');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    //修改问题
    public function actionUpdateQuestion($id){
        $model=Question::findOne($id);
        return $this->render('update-question',[
            'model'=>$model
        ]);
    }
    
    //问题上移
    public function actionMoveUp($id){
     $question=Question::findOne($id);
      if(!empty($question->code)){
          if($question->code==1){
              yii::$app->getSession()->setFlash('error','已经是第一题了,不能再上移!');
              return $this->redirect(yii::$app->request->referrer);
          }
          $upcode=$question->code-1;
          $upquestion=Question::findOne(['task_guid'=>$question->task_guid,'code'=>$upcode]);
          if(!empty($upquestion)){
              $upquestion->code=$question->code;
              if($upquestion->save()){
                  $question->code=$upcode;
                  if($question->save()){
                      yii::$app->getSession()->setFlash('success','问题上移成功');
                      return $this->redirect(yii::$app->request->referrer);
                  }
              }
          }
      }
      yii::$app->getSession()->setFlash('error','问题上移失败!');
      return $this->redirect(yii::$app->request->referrer);
    }
    
    //问题下移
    public function actionMoveDown($id){
        $question=Question::findOne($id);
        if(!empty($question)&&!empty($question->code)){
            $countQuestion=Question::find()->andWhere(['task_guid'=>$question->task_guid])->count();
            
            if($question->code==$countQuestion){
                yii::$app->getSession()->setFlash('error','已经是最后一题了,不能再下移!');
                return $this->redirect(yii::$app->request->referrer);
            }
            $downcode=$question->code+1;
            $downquestion=Question::findOne(['task_guid'=>$question->task_guid,'code'=>$downcode]);
            if(!empty($downquestion)){
                $downquestion->code=$question->code;
                if($downquestion->save()){
                    $question->code=$downcode;
                    if($question->save()){
                        yii::$app->getSession()->setFlash('success','问题上移成功');
                        return $this->redirect(yii::$app->request->referrer);
                    }
                }
            }
        }
        yii::$app->getSession()->setFlash('error','问题下移失败!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       $model->end_time=date('Y-m-d H:i',$model->end_time);
       $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->total_price=$model->price*$model->number;
            $model->end_time=strtotime($model->end_time);
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            if(empty($model->group_id)){
                $model->group_id=0;
            }
            $model->desc=@$_POST['desc'];
            $model->updated_at=time();
            $address=$model->address;
            //地址转经纬度
            $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
            $result=$geoCoding->getLngLatFromAddress(urldecode($address));
            if($result['status']==0){
                $model->lng=$result['result']['location']['lng'];
                $model->lat=$result['result']['location']['lat'];
                $model->lnglat=CommonUtil::getGeomLnglat($model->lng, $model->lat);
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                yii::$app->getSession()->setFlash('error','任务创建失败!');
            }
         
        } else {
            $group=Group::find()->andWhere(['create_by'=>yii::$app->user->identity->user_guid])->all();
            return $this->render('update', [
                'model' => $model,
                'group'=>$group
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    //一审
    public function actionFirstAuth(){
        $id=$_POST['answer_id'];
        $answer=Answer::findOne($id);
        $user_guid=yii::$app->user->identity->user_guid;
        if(empty($answer)){
            yii::$app->getSession()->setFlash('error','您审核的答案不存在!');
            return $this->redirect(yii::$app->request->referrer);
        }
        $answer->first_auth=$_POST['first-auth'];
        $answer->first_auth_user=$user_guid;
        $answer->first_auth_remark=@$_POST['first-auth-remark'];
        $answer->updated_at=time();
        if($answer->save()){
            $message=new Message();
             $task=Task::findOne(['task_guid'=>$answer->task_guid]);
            $content="";
            if($answer->first_auth==1){
                $title="<span class='orange'>".$task->name."</span> 一审通过";
                  $content="您提交的任务 <span class='orange'>".$task->name."</span> 一审通过;审核意见:<span class='orange'>".$answer->first_auth_remark.'</span>;请等待二审结果.';
            }elseif($answer->first_auth==99){
                $title="<span class='orange'>".$task->name."</span> 一审未通过";
                  $content="您提交的任务<span class='orange'>".$task->name."</span> 一审未通过;审核意见:<span class='orange'>".$answer->first_auth_remark.'</span>;请等待二审结果.';
            }
         
            $message->sendMessage(null,$answer->user_guid,$title, $content);
            yii::$app->getSession()->setFlash('success','审核成功!');
            return $this->redirect(yii::$app->request->referrer);
        }
    }
    
    //二审
    public function actionSecAuth(){
        $id=$_POST['answer_id'];
        $answer=Answer::findOne($id);
        $user_guid=yii::$app->user->identity->user_guid;
        if(empty($answer)){
            yii::$app->getSession()->setFlash('error','您审核的答案不存在!');
            return $this->redirect(yii::$app->request->referrer);
        }
        $answer->second_auth=$_POST['sec-auth'];
        $answer->second_auth_user=$user_guid;
        /*if($answer->second_auth==1){
            $answer->status=3;
        }else*/
        if ($answer->second_auth==99){
            $answer->status=99;//审核未通过
        }else{
            $answer->status=3;//审核通过
        }
        $answer->second_auth_remark=@$_POST['sec-auth-remark'];
        $answer->updated_at=time();
        $trans=yii::$app->db->beginTransaction();
        try{
      
            $message=new Message();
            $task=Task::findOne(['task_guid'=>$answer->task_guid]);
            $content="";
            if($answer->second_auth==1){
                $answer->auth_pass_rate=0.25;
                $title="<span class='orange'>".$task->name."</span> 二审25%通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审25%通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span> ;任务奖励已发放到您的账户中，到个人中心-我的钱包里查看';
            }elseif($answer->second_auth==2){
                $answer->auth_pass_rate=0.5;
                $title="<span class='orange'>".$task->name."</span> 二审50%通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审50%通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span> ;任务奖励已发放到您的账户中，到个人中心-我的钱包里查看';
            }elseif($answer->second_auth==3){
                $answer->auth_pass_rate=0.75;
                $title="<span class='orange'>".$task->name."</span> 二审75%通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审75%通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span> ;任务奖励已发放到您的账户中，到个人中心-我的钱包里查看';
            }elseif($answer->second_auth==4){
                $answer->auth_pass_rate=1;
                $title="<span class='orange'>".$task->name."</span> 二审通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span> ;任务奖励已发放到您的账户中，到个人中心-我的钱包里查看';
            }elseif($answer->second_auth==98){
                $other=0;
                $other=intval($_POST['other']);
                $answer->auth_pass_rate=round($other/100,2);
                if($other<=0 ||$other>=100){
                    yii::$app->getSession()->setFlash('error','您输入的数字不在范围内,请输入1-99之间的数字!');
                    return $this->redirect(yii::$app->request->referrer);
                }

           $title="<span class='orange'>".$task->name."</span> 二审$other%通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审$other%通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span> ;任务奖励已发放到您的账户中，到个人中心-我的钱包里查看';
            }elseif($answer->second_auth==99){
                $answer->auth_pass_rate=0;
                $title="<span class='orange'>".$task->name."</span> 二审未通过";
                $content="您提交的任务 <span class='orange'>".$task->name."</span> 二审未通过;审核意见: <span class='orange'>".$answer->second_auth_remark.'</span>;';
            }
            
            if(!$answer->save()) throw new Exception('Insert answer fail!');
            
            $message->sendMessage(null,$answer->user_guid,$title, $content);
            if($answer->second_auth!=99){
                    $incomeRec=IncomeRec::findOne(['user_guid'=>$answer->user_guid,'task_guid'=>$answer->task_guid,'answer_guid'=>$answer->answer_guid]);
                    if(empty($incomeRec)){
                    $task=Task::findOne(['task_guid'=>$answer->task_guid]);
                    $incomeRec=new IncomeRec();
                    $incomeRec->owner_user=$task->user_guid;
                    $incomeRec->user_guid=$answer->user_guid;
                    $incomeRec->task_guid=$answer->task_guid;
                    $incomeRec->answer_guid=$answer->answer_guid;
                        if($answer->second_auth==1){
                            $incomeRec->amount=round($task->price*0.25,2);
                        }elseif($answer->second_auth==2){
                            $incomeRec->amount=round($task->price*0.5,2);
                        }elseif($answer->second_auth==3){
                            $incomeRec->amount=round($task->price*0.75,2);
                        }elseif($answer->second_auth==4){
                            $incomeRec->amount=$task->price;
                        }elseif($answer->second_auth==98){
                            $other=$_POST['other']/100;
                            $incomeRec->amount=round($task->price*$other,2);
                        }

                    $incomeRec->remark="完成任务-".$task->name.",并通过审核。";
                    $incomeRec->created_at=time();
                    if(!$incomeRec->save()) throw new Exception('insert incomeRec fail!');
                   
                    $wallet=Wallet::findOne(['user_guid'=>$answer->user_guid]);
                    if(empty($wallet)){
                        $wallet= new Wallet();
                        $wallet->user_guid=$answer->user_guid;
                        $wallet->created_at=time();
                    }else {
                        $wallet->updated_at=time();
                    }
                    $wallet->non_payment += $incomeRec->amount;
                    $wallet->total_income +=$incomeRec->amount;
                    if(!$wallet->save()) throw new Exception("insert wallet fail!");
                    }
            }
             $trans->commit();
            
            yii::$app->getSession()->setFlash('success','审核成功!');
            return $this->redirect(yii::$app->request->referrer);
        
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','审核失败!');
            return $this->redirect(yii::$app->request->referrer);
        }
    }
    
    public function actionPublishTemplate(){
        $task_guid=$_POST['task_guid'];
        $task=Task::findOne(['task_guid'=>$task_guid]);
    
        $questionArr=Question::findAll(['task_guid'=>$task_guid]);
        if(empty($questionArr)){
            yii::$app->getSession()->setFlash('error','设置失败!当前问卷没有编辑问题!');
            return $this->redirect(yii::$app->request->referrer);
        }
        $user_guid=yii::$app->user->identity->user_guid;
        $transaction=yii::$app->db->beginTransaction();
        try{
        $template=new Template();
        $template->name=$_POST['template-name'];
        $template->user_guid=$user_guid;
        $template->templateno=Template::createTemplateno();
        $template->is_auth=1;
        $template->created_at=time();
        if(!$template->save()) throw new Exception();
        
        foreach ($questionArr as $k=>$v){
            $templateQuestion=new TemplateQuestion();
            $templateQuestion->templateno=$template->templateno;
            $templateQuestion->name=$v['name'];
            $templateQuestion->code=$v['code'];
            $templateQuestion->options=$v['options'];
            $templateQuestion->type=$v['type'];
            $templateQuestion->user_guid=$user_guid;
            $templateQuestion->qrcode_value=$v['qrcode_value'];
            $templateQuestion->max_photo=$v['max_photo'];
            $templateQuestion->required=$v['required'];
            $templateQuestion->created_at=time();
            if(!$templateQuestion->save()) throw new Exception();
        }
        
        $task->templateno=$template->templateno;
        if(!$task->save()) throw new Exception();
            $transaction->commit();
            yii::$app->getSession()->setFlash('success','设置成功!');
        return $this->redirect(yii::$app->request->referrer);
        }catch (Exception $e){
            $transaction->rollBack();
               yii::$app->getSession()->setFlash('error','设置失败!数据库错误!');
            return $this->redirect(yii::$app->request->referrer);
        }
        
    }
    
    public function actionPublishTaskTemplate(){
        $task_guid=$_POST['task_guid'];
        $task=Task::findOne(['task_guid'=>$task_guid]);
        
        $questionArr=Question::findAll(['task_guid'=>$task_guid]);
        if(empty($questionArr)){
            yii::$app->getSession()->setFlash('error','设置失败!当前问卷没有编辑问题!');
            return $this->redirect(yii::$app->request->referrer);
        }
        $user_guid=yii::$app->user->identity->user_guid;
        $transaction=yii::$app->db->beginTransaction();
        try{
            $template=new Template();
            $template->name=$_POST['template-name']."-问卷模板";
            $template->user_guid=$user_guid;
            $template->templateno=Template::createTemplateno();
            $template->is_auth=1;
            $template->created_at=time();
            if(!$template->save()) throw new Exception('新建模板失败');
    
            foreach ($questionArr as $k=>$v){
                $templateQuestion=new TemplateQuestion();
                $templateQuestion->templateno=$template->templateno;
                $templateQuestion->name=$v['name'];
                $templateQuestion->code=$v['code'];
                $templateQuestion->options=$v['options'];
                $templateQuestion->type=$v['type'];
                $templateQuestion->user_guid=$user_guid;
                $templateQuestion->qrcode_value=$v['qrcode_value'];
                $templateQuestion->max_photo=$v['max_photo'];
                $templateQuestion->required=$v['required'];
                $templateQuestion->created_at=time();
                if(!$templateQuestion->save()) throw new Exception('保存问卷失败');
            }
            
            $taskTemplate=new TaskTemplate();
            $taskTemplate->task_templateno=TaskTemplate::generateTaskTemplateNO();
            $taskTemplate->user_guid=yii::$app->user->identity->user_guid;
            $taskTemplate->name=$_POST['template-name'];
            $taskTemplate->templateno=$template->templateno;
            $taskTemplate->desc=$task->desc;
            $taskTemplate->type=$task->type;
            $taskTemplate->province=$task->province;
            $taskTemplate->city=$task->city;
            $taskTemplate->district=$task->district;
            $taskTemplate->price=$task->price;
            $taskTemplate->number=$task->number;
            $taskTemplate->end_time=$task->end_time;
            $taskTemplate->address=$task->address;
            $taskTemplate->lng=$task->lng;
            $taskTemplate->lat=$task->lat;
            $taskTemplate->radius=$task->radius;
            $taskTemplate->total_price=$task->total_price;
            $taskTemplate->group_id=$task->group_id;
            $taskTemplate->post_type=$task->post_type;
            $taskTemplate->lnglat=$task->lnglat;
            $taskTemplate->do_type=$task->do_type;
            $taskTemplate->path=$task->path;
            $taskTemplate->photo=$task->photo;
            $taskTemplate->do_radius=$task->do_radius;
            $taskTemplate->answer_type=$task->answer_type;
            $taskTemplate->answer_radius=$task->answer_radius;
            $taskTemplate->max_times=$task->max_times;
            $taskTemplate->created_at=time();
            if(!$taskTemplate->save()) throw new Exception('保存任务模板失败');
            
            $task->task_templateno=$taskTemplate->task_templateno;
            $task->templateno=$template->templateno;
            if(!$task->save()) throw new Exception('更新任务失败');
            $transaction->commit();
            yii::$app->getSession()->setFlash('success','设置成功!');
            return $this->redirect(yii::$app->request->referrer);
        }catch (Exception $e){
            $transaction->rollBack();
            yii::$app->getSession()->setFlash('error','设置失败!数据库错误!');
            return $this->redirect(yii::$app->request->referrer);
        }
    }
    
    
    public function actionViewAnswerAuth($id){
        $answer=Answer::findOne($id);
        return $this->render('view-answer-auth',[
            'answer'=>$answer
        ]);
    }

//导出问题答案
    public function actionExportAnswer($id,$status){
        $task=Task::findOne($id);
        $task_guid=$task->task_guid;
        if($status==0){
            $answerArr=Answer::findAll(['task_guid'=>$task_guid]);
        }else{
            $answerArr=Answer::findAll(['task_guid'=>$task_guid,'status'=>$status]);
        }

        if(empty($answerArr)){
            yii::$app->getSession()->setFlash('error','没有数据哦!');
            return $this->redirect(yii::$app->request->referrer);
        }
        $resultExcel=new \PHPExcel();
        $resultExcel->getActiveSheet()->setCellValue('A1','序号');
        $resultExcel->getActiveSheet()->setCellValue('B1','答案唯一编号');
        $resultExcel->getActiveSheet()->setCellValue('C1','任务名称');
        $resultExcel->getActiveSheet()->setCellValue('D1','姓名');
        $resultExcel->getActiveSheet()->setCellValue('E1','手机号');
        $resultExcel->getActiveSheet()->setCellValue('F1','状态');
        $resultExcel->getActiveSheet()->setCellValue('G1','一审结果');
        $resultExcel->getActiveSheet()->setCellValue('H1','一审意见');
        $resultExcel->getActiveSheet()->setCellValue('I1','二审结果');
        $resultExcel->getActiveSheet()->setCellValue('J1','二审意见');
        $resultExcel->getActiveSheet()->setCellValue('K1','任务预定地址');
        $resultExcel->getActiveSheet()->setCellValue('L1','任务预定唯一编号');
        $resultExcel->getActiveSheet()->setCellValue('M1','领取时间');
        $resultExcel->getActiveSheet()->setCellValue('N1','领取地点');
        $resultExcel->getActiveSheet()->setCellValue('O1','答题时间');
        $resultExcel->getActiveSheet()->setCellValue('P1','答题地点');
        $resultExcel->getActiveSheet()->setCellValue('Q1','提交时间');
        $resultExcel->getActiveSheet()->setCellValue('R1','答题时长(秒)');
        $resultExcel->getActiveSheet()->setCellValue('S1','提交地点');

        $questions=Question::find()->andWhere(['task_guid'=>$task_guid])->orderBy('code asc')->all();
        $col='S';
        foreach ($questions as $k=>$v){
            $col++;
            $result =($k+1).'.【'.CommonUtil::getDescByValue('question', 'type', $v->type).'】'.$v->name;
            $resultExcel->getActiveSheet()->setCellValue($col.'1',$result);
        }

        $i=2;
        foreach ($answerArr as $key=>$item){
            $resultExcel->getActiveSheet()->setCellValue('A'.$i,$key+1);
            $resultExcel->getActiveSheet()->setCellValue('B'.$i,$item['answer_guid']);
            $resultExcel->getActiveSheet()->setCellValue('C'.$i,$task['name']);
            $resultExcel->getActiveSheet()->setCellValue('D'.$i,empty($item['user'])?'':$item['user']['name']);
            $resultExcel->getActiveSheet()->setCellValue('E'.$i,empty($item['user'])?'':$item['user']['mobile']);
            $resultExcel->getActiveSheet()->setCellValue('F'.$i,CommonUtil::getDescByValue('answer', 'status', $item['status']));
            $resultExcel->getActiveSheet()->setCellValue('G'.$i,CommonUtil::getDescByValue('answer', 'first_auth', $item['first_auth']));
            $resultExcel->getActiveSheet()->setCellValue('H'.$i,$item['first_auth_remark']);
            $resultExcel->getActiveSheet()->setCellValue('I'.$i,CommonUtil::getDescByValue('answer', 'second_auth', $item['second_auth']));
            $resultExcel->getActiveSheet()->setCellValue('J'.$i,$item['second_auth_remark']);
            $resultExcel->getActiveSheet()->setCellValue('K'.$i,@$item['task']['address']);
            $resultExcel->getActiveSheet()->setCellValue('L'.$i,@$item['task']['taskno']);
            $resultExcel->getActiveSheet()->setCellValue('M'.$i,CommonUtil::fomatTime($item['start_time']));
            $resultExcel->getActiveSheet()->setCellValue('N'.$i,$item['start_address']);
            $resultExcel->getActiveSheet()->setCellValue('O'.$i,CommonUtil::fomatTime($item['answer_time']));
            $resultExcel->getActiveSheet()->setCellValue('P'.$i,$item['answer_address']);
            $resultExcel->getActiveSheet()->setCellValue('Q'.$i,CommonUtil::fomatTime($item['end_time']));
            $resultExcel->getActiveSheet()->setCellValue('R'.$i,$item['end_time']-$item['answer_time']);
            $resultExcel->getActiveSheet()->setCellValue('S'.$i,$item['submit_address']);

            $col='S';
            foreach ($questions as $k=>$v){
                $col++;
                if($v->type==0){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail)){
                        $optArr=explode(':', $answerDetail->answer);
                        $result ='选项'.($optArr[0]+1) .'、'.$optArr[1];
                        if(!empty($answerDetail->open_answer)){
                            $result.=';'.$answerDetail->open_answer;
                        }
                    }

                    $resultExcel->getActiveSheet()->setCellValue($col.$i,$result);
                }elseif ($v->type==1){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail)){
                        $optArrs=json_decode($answerDetail->answer,true);
                        foreach ($optArrs as $a){
                            $optArr=explode(':', $a);
                            $result .= '选项'.($optArr[0]+1) .'、'.$optArr[1].";";
                        }
                        $resultExcel->getActiveSheet()->setCellValue($col.$i,$result);
                    }
                }elseif($v->type==2 || $v->type==6  || $v->type==7){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail->answer)){
                        $result =$answerDetail->answer;
                    }

                    $resultExcel->getActiveSheet()->setCellValue($col.$i,$result);
                }elseif ($v->type==3){
                    $answerDetail=AnswerDetail::findAll(['answer_guid'=>$item['answer_guid'],'task_guid'=>$task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    if(!empty($answerDetail)){
                        $url=yii::$app->urlManager->createAbsoluteUrl(['task/view-answer-photo', 'answer_guid'=>$item['answer_guid'],'task_guid'=>$task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        $resultExcel->getActiveSheet()->setCellValue($col.$i,"图片");
                        $resultExcel->getActiveSheet()->getCell($col.$i)->getHyperlink()->setUrl($url);
                        $resultExcel->getActiveSheet()->getStyle($col.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                }

            }
            $i++;
        }

        //设置导出文件名
        $outputFileName =$task->name."-任务结果".date('Y-m-d',time()).'.xls';
        $xlsWriter = new \PHPExcel_Writer_Excel5($resultExcel);
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");

        $xlsWriter->save( "php://output" );
    }


    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
