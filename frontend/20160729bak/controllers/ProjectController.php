<?php

namespace frontend\Controllers;

use Yii;
use common\models\Project;
use common\models\SearchProject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Task;
use common\models\CommonUtil;
use common\models\TemplateQuestion;
use common\models\Question;
use common\models\GeoCoding;
use common\models\SearchTask;
use common\models\Answer;
use common\models\AnswerDetail;
use common\models\TaskTemplate;
use yii\filters\AccessControl;
use common\models\Group;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProject();
        $searchModel->user_guid=yii::$app->user->identity->user_guid;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $searchModel = new SearchTask();
        $searchModel->project_id=$model->id;
        $searchModel->post_type=1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_guid=yii::$app->user->identity->user_guid;
            $model->post_type=2;
            $model->created_at=time();
            if(  $model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //问卷模板批量导入任务
    public function actionImportTask()
    {
        $project_id=$_POST['project_id'];
        $user_guid=yii::$app->user->identity->user_guid;
        $file=UploadedFile::getInstanceByName('taskfile');
        if(!isset($file)){
            yii::$app->getSession()->setFlash('error','文件上传失败,请重试');
            return $this->redirect(yii::$app->request->referrer);
        }
        if ($file->extension!='xls'&&$file->extension!='xlsx'){
            yii::$app->getSession()->setFlash('error','导入失败,请上传excel文件');
            return $this->redirect(yii::$app->request->referrer);
        }
        $objPHPExcel = \PHPExcel_IOFactory::load($file->tempName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,false,true,true);
        $result = 0;
        $irecord = 0;
        foreach ($sheetData as $record)
        {
            $irecord++;
            if($irecord<2){
                continue;
            }
             
           $task=new Task();
           $task->user_guid=$user_guid;
           $task->task_guid=CommonUtil::createUuid();
           $task->name=trim($record['A']);
           $task->type=CommonUtil::getTaskType(trim($record['B']));
           $task->do_type=CommonUtil::getTaskDoType(trim($record['C']));
           $task->answer_type=CommonUtil::getTaskAnswerType(trim($record['D']));
           $task->radius=trim($record['E']);
           $task->do_radius=trim($record['F']);
           $task->answer_radius=trim($record['G']);
           $task->price=trim($record['H']);
           $task->number=trim($record['I']);
           $task->province=trim($record['J']);
           $task->city=trim($record['K']);
           $task->district=trim($record['L']);
           $task->address=trim($record['M']);
           $task->end_time=strtotime(trim($record['N']));
           $task->templateno=trim($record['O']);
           $task->desc=trim($record['P']);
            $task->taskno=trim($record['Q']);
           $task->project_id=$project_id;
           $task->created_at=time();
           
           //地址转经纬度
           $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
           $georesult=$geoCoding->getLngLatFromAddress(urldecode($task->address));
           if($georesult['status']==0){
               $task->lng=$georesult['result']['location']['lng'];
               $task->lat=$georesult['result']['location']['lat'];
               $task->lnglat=CommonUtil::getGeomLnglat($task->lng, $task->lat);
           }
           
           if($task->save()){
               $templateQuestion=TemplateQuestion::findAll(['templateno'=>$task->templateno]);
               if(!empty($templateQuestion)){
                   foreach ($templateQuestion as $k=>$v){
                       $question=new Question();
                       $question->task_guid=$task->task_guid;
                       $question->question_guid=CommonUtil::createUuid();
                       $question->user_guid=$user_guid;
                       $question->code=$v->code;
                       $question->type=$v->type;
                       $question->name=$v->name;
                       $question->options=$v->options;
                       $question->qrcode_value=$v->qrcode_value;
                       $question->max_photo=$v->max_photo;
                       $question->required=$v->required;
                       $question->created_at=time();
                       $question->save();
                   }
               }
               $result++;
           }
           
        }
        
        $project=Project::findOne($project_id);
        $project->tasknum+=$result;
        $project->save();
        yii::$app->getSession()->setFlash('success','导入成功,本次导入'.$result.'条数据');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    
    //任务模板-批量导入任务
    public function actionImportTaskTemplate()
    {
        $project_id=$_POST['project_id'];
        $user_guid=yii::$app->user->identity->user_guid;
        $file=UploadedFile::getInstanceByName('tasktemplatefile');
        if(!isset($file)){
            yii::$app->getSession()->setFlash('error','文件上传失败,请重试');
            return $this->redirect(yii::$app->request->referrer);
        }
        if ($file->extension!='xls'&&$file->extension!='xlsx'){
            yii::$app->getSession()->setFlash('error','导入失败,请上传excel文件');
            return $this->redirect(yii::$app->request->referrer);
        }
        $objPHPExcel = \PHPExcel_IOFactory::load($file->tempName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,false,true,true);
        $result = 0;
        $irecord = 0;
        foreach ($sheetData as $record)
        {
            $irecord++;
            if($irecord<2){
                continue;
            }
            $taskTemplate=TaskTemplate::findOne(['task_templateno'=>trim($record['G'])]);
            if(empty($taskTemplate)){
                continue;
            }
            $task=new Task();
            $task->user_guid=$user_guid;
            $task->task_guid=CommonUtil::createUuid();
            $task->name=trim($record['A']);
            $task->type=$taskTemplate->type;
            $task->do_type=$taskTemplate->do_type;
            $task->answer_type=$taskTemplate->answer_type;
            $task->radius=$taskTemplate->radius;
            $task->do_radius=$taskTemplate->do_radius;
            $task->answer_radius=$taskTemplate->answer_radius;
            $task->price=$taskTemplate->price;
            $task->number=$taskTemplate->number;
            $task->province=trim($record['B']);
            $task->city=trim($record['C']);
            $task->district=trim($record['D']);
            $task->address=trim($record['E']);
            $task->end_time=strtotime(trim($record['F']));
            $task->templateno=$taskTemplate->templateno;
            $task->desc=$taskTemplate->desc;
            $task->taskno=trim($record['H']);
            $task->project_id=$project_id;
            $task->created_at=time();
             
            //地址转经纬度
            $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
            $georesult=$geoCoding->getLngLatFromAddress(urldecode($task->address));
            if($georesult['status']==0){
                $task->lng=$georesult['result']['location']['lng'];
                $task->lat=$georesult['result']['location']['lat'];
                $task->lnglat=CommonUtil::getGeomLnglat($task->lng, $task->lat);
            }
             
            if($task->save()){
                $templateQuestion=TemplateQuestion::findAll(['templateno'=>$task->templateno]);
                if(!empty($templateQuestion)){
                    foreach ($templateQuestion as $k=>$v){
                        $question=new Question();
                        $question->task_guid=$task->task_guid;
                        $question->question_guid=CommonUtil::createUuid();
                        $question->user_guid=$user_guid;
                        $question->code=$v->code;
                        $question->type=$v->type;
                        $question->name=$v->name;
                        $question->options=$v->options;
                        $question->qrcode_value=$v->qrcode_value;
                        $question->max_photo=$v->max_photo;
                        $question->required=$v->required;
                        $question->created_at=time();
                        $question->save();
                    }
                }
                $result++;
            }
             
        }
    
        $project=Project::findOne($project_id);
        $project->tasknum+=$result;
        $project->save();
        yii::$app->getSession()->setFlash('success','导入成功,本次导入'.$result.'条数据');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    
    
    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateTask($id){
        $model=Task::findOne(['project_id'=>$id]);
        $project=Project::findOne($id);
         if(empty($model)){
             yii::$app->getSession()->setFlash('error','该项目还未导入任务,请导入或创建任务后再操作!');
             return $this->redirect(yii::$app->request->referrer);
         }
         $model->end_time=date('Y-m-d H:i:s',$model->end_time);
        if($model->load(yii::$app->request->post())){
            Task::updateAll([
                'type'=>$model->type,
                'answer_type'=>$model->answer_type,
                'answer_radius'=>$model->answer_radius,
                'radius'=>$model->radius,
                'do_radius'=>$model->do_radius,
                'group_id'=>empty($model->group_id)?'0':$model->group_id,
                'price'=>$model->price,
                'number'=>$model->number,
                'is_show_price'=>$model->is_show_price,
                'do_type'=>$model->do_type,
                'max_times'=>$model->max_times,
                'end_time'=> strtotime($model->end_time),
                'desc'=>@$_POST['desc']
            ],['project_id'=>$id]);
            return $this->redirect(['view','id'=>$id]);
        }
        $group=Group::find()->all();
        return $this->render('update-task',['model'=>$model,
            'group'=>$group,
            'project'=>$project
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Task::deleteAll(['project_id'=>$id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionBatchPublish($project_id){
        Task::updateAll(['status'=>1],['project_id'=>$project_id,'status'=>0]);
        yii::$app->getSession()->setFlash('success','批量发布成功!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionBatchPass($project_id){
        Task::updateAll(['status'=>2],['project_id'=>$project_id,'status'=>1]);
        yii::$app->getSession()->setFlash('success','批量审核通过成功!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionBatchOffLine($project_id){
        Task::updateAll(['status'=>3],['project_id'=>$project_id,'status'=>2]);
        yii::$app->getSession()->setFlash('success','批量下线成功!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionBatchOnline(){
        $id=$_POST['project_id'];
        $end_time=strtotime($_POST['end_time']);
        Task::updateAll(['status'=>1,'end_time'=>$end_time],['project_id'=>$id]);
    
        yii::$app->getSession()->setFlash('success','批量上线成功，请等待平台管理员审核！');
        return $this->redirect(yii::$app->request->referrer);
    }
    
     //导出问题答案
    public function actionBatchExportAnswer($project_id){
        $project=Project::findOne($project_id);
        $taskArr=Task::find()->andWhere(['project_id'=>$project_id])->all();
        $targetPath="../../upload/answer/";
        if(!is_dir($targetPath)){
            mkdir($targetPath);
        }
        $targetDir=$targetPath.date('YmdHis').'/';
        if(!is_dir($targetDir)){
            mkdir($targetDir);
        }
        
    
        if(empty($taskArr)){
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
       
        $taskOne=Task::findOne(['project_id'=>$project_id]);
        $questions=Question::find()->andWhere(['task_guid'=>$taskOne->task_guid])->orderBy('code asc')->all();
        $col='S';
        foreach ($questions as $k=>$v){
            $col++;
            $result =($k+1).'.【'.CommonUtil::getDescByValue('question', 'type', $v->type).'】'.$v->name;
            $resultExcel->getActiveSheet()->setCellValue($col.'1',$result);
        }
        
        $i=2;
        foreach ($taskArr as $ky=>$im){
            $answerArr=Answer::findAll(['task_guid'=>$im->task_guid]);
            $taskFolder=$targetDir.$im->name.'/';
            if(!is_dir($taskFolder)){
                mkdir($taskFolder);
            }
          foreach ($answerArr as $key=>$item){
            $resultExcel->getActiveSheet()->setCellValue('A'.$i,$key+1);
            $resultExcel->getActiveSheet()->setCellValue('B'.$i,$item['answer_guid']);
            $resultExcel->getActiveSheet()->setCellValue('C'.$i,$im['name']);
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
            $questions=Question::find()->andWhere(['task_guid'=>$im->task_guid])->orderBy('code asc')->all();
            foreach ($questions as $k=>$v){ 
                $col++;
                if($v->type==0){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail)){
                        $optArr=explode(':', $answerDetail->answer);
                        $result ='选项'.($optArr[0]+1) .'、'.$optArr[1];
                        if(!empty($answerDetail->open_answer)){
                            $result.=';'.$answerDetail->open_answer;
                        }
                    }
                  
    
                    $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                }elseif ($v->type==1){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail)){
                        $optArrs=json_decode($answerDetail->answer,true);
                        foreach ($optArrs as $a){
                            $optArr=explode(':', $a);
                            $result .= '选项'.($optArr[0]+1) .'、'.$optArr[1].";";
                        }
                        $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                    }
                }elseif($v->type==2 || $v->type==6  || $v->type==7){
                    $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    $result="";
                    if(!empty($answerDetail->answer)){
                        $result =$answerDetail->answer;
                    }
    
                    $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                }elseif ($v->type==3){
                    $answerDetail=AnswerDetail::findAll(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                    if(!empty($answerDetail)){
                        $url=yii::$app->urlManager->createAbsoluteUrl(['task/view-answer-photo','answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,"图片");
                        $resultExcel->getActiveSheet()->getCell((string)$col.(string)$i)->getHyperlink()->setUrl($url);
                        $resultExcel->getActiveSheet()->getStyle((string)$col.(string)$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    
                }
               
            }
            $i++;
//             $lastFolder=empty($item['user']['name'])?$item['user']['mobile']:$item['user']['name'];
//             $baseDir='../../upload/photo/';
//             $answerDetail=AnswerDetail::findAll(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid'],'type'=>3]);
//             print_r($answerDetail);die;
//             foreach ($answerDetail as $answer){
//                 $userFolder=$taskFolder.$lastFolder.'/';
//                 if(!is_dir($userFolder)){
//                     mkdir($userFolder);
//                 }
//                 $file=$baseDir.$answer->path.$answer->photo;
//                 echo $file;die;
//                     copy($file, $userFolder.$answer->photo);
                
//             }
            
           }
           
           $baseDir='../../upload/photo/';
           $answerDetail=AnswerDetail::findAll(['task_guid'=>$im->task_guid,'type'=>3]);
           foreach ($answerDetail as $answer){
               $file=$baseDir.$answer->path.$answer->photo;
               if(is_file($file) && file_exists($file)){
                   copy($file, $taskFolder.$answer->photo);
               }
               
           }
          
        }
     
    
        //设置导出文件名
        $outputFileName =$project->name."-任务结果".date('Y-m-d').'.xls';
        $xlsWriter = new \PHPExcel_Writer_Excel5($resultExcel);
        $xlsWriter->save( $targetDir.$outputFileName);
        
        
        $filename = $project->name.date('YmdHis').'.zip'; //最终生成的文件名（含路径）
        if(!file_exists($filename)){
            //重新生成文件
            $zip =  new \Zip();
            $zip->addDirectoryContent($targetDir, $project->name.date('YmdHis'));
            /*   foreach( $datalist as $val){
             $zip->addFile( file_get_contents($val), $val);
             } */
            $zip->sendZip($filename);
        }
        if(!file_exists($filename)){
            exit("无法找到文件"); //即使创建，仍有可能失败。。。。
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header('Content-disposition: attachment; filename='.basename($filename)); //文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小
    }
    

    //导出问题答案
    public function actionBatchExportExcel($project_id){
        $project=Project::findOne($project_id);
        $taskArr=Task::find()->andWhere(['project_id'=>$project_id])->all();
    
        if(empty($taskArr)){
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
         
        $taskOne=Task::findOne(['project_id'=>$project_id]);
        $questions=Question::find()->andWhere(['task_guid'=>$taskOne->task_guid])->orderBy('code asc')->all();
        $col='S';
        foreach ($questions as $k=>$v){
            $col++;
            $result =($k+1).'.【'.CommonUtil::getDescByValue('question', 'type', $v->type).'】'.$v->name;
            $resultExcel->getActiveSheet()->setCellValue($col.'1',$result);
        }
    
        $i=2;
        foreach ($taskArr as $ky=>$im){
            $answerArr=Answer::findAll(['task_guid'=>$im->task_guid]);
    
            foreach ($answerArr as $key=>$item){
                $resultExcel->getActiveSheet()->setCellValue('A'.$i,$key+1);
                $resultExcel->getActiveSheet()->setCellValue('B'.$i,$item['answer_guid']);
                $resultExcel->getActiveSheet()->setCellValue('C'.$i,$im['name']);
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
                $questions=Question::find()->andWhere(['task_guid'=>$im->task_guid])->orderBy('code asc')->all();
                foreach ($questions as $k=>$v){
                    $col++;
                    if($v->type==0){
                        $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        $result="";
                        if(!empty($answerDetail)){
                            $optArr=explode(':', $answerDetail->answer);
                            $result ='选项'.($optArr[0]+1) .'、'.$optArr[1];
                            if(!empty($answerDetail->open_answer)){
                                $result.=';'.$answerDetail->open_answer;
                            }
                        }
    
    
                        $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                    }elseif ($v->type==1){
                        $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        $result="";
                        if(!empty($answerDetail)){
                            $optArrs=json_decode($answerDetail->answer,true);
                            foreach ($optArrs as $a){
                                $optArr=explode(':', $a);
                                $result .= '选项'.($optArr[0]+1) .'、'.$optArr[1].";";
                            }
                            $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                        }
                    }elseif($v->type==2 || $v->type==6  || $v->type==7){
                        $answerDetail=AnswerDetail::findOne(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        $result="";
                        if(!empty($answerDetail->answer)){
                            $result =$answerDetail->answer;
                        }
    
                        $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,$result);
                    }elseif ($v->type==3){
                        $answerDetail=AnswerDetail::findAll(['answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                        if(!empty($answerDetail)){
                            $url=yii::$app->urlManager->createAbsoluteUrl(['task/view-answer-photo','answer_guid'=>$item['answer_guid'],'task_guid'=>$im->task_guid,'question_guid'=>$v['question_guid'],'user_guid'=>$item['user_guid']]);
                            $resultExcel->getActiveSheet()->setCellValue((string)$col.(string)$i,"图片");
                            $resultExcel->getActiveSheet()->getCell((string)$col.(string)$i)->getHyperlink()->setUrl($url);
                            $resultExcel->getActiveSheet()->getStyle((string)$col.(string)$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        }
    
                    }
                     
                }
                $i++;
    
            }
             
    
        }
    
        //设置导出文件名
        $outputFileName =$project->name."-任务结果".date('Y-m-d').'.xls';
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
