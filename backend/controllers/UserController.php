<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Group;
use common\models\GroupUser;
use common\models\LoginRec;
use common\models\Answer;
use common\models\CommonUtil;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * 会员管理
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionUpdateUserAddress(){
        $i=0;
        foreach (User::find()->each(10) as $user){
            if(empty($user->address)){
                $loginRec=LoginRec::find()->andWhere(['user_guid'=>$user->user_guid,'address'=>null])->orderBy('time asc')->one();
                if(!empty($loginRec) && !empty($loginRec->address)){
                    $user->address=$loginRec->address;
                    $user->save();
                    $i++;
                }
            }
        }
        yii::$app->getSession()->setFlash('error','更新'.$i.'条数据!');
        return  $this->redirect(yii::$app->request->referrer);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewTask($id)
    {
        $model=$this->findModel($id);
        $dataProvider=new ActiveDataProvider([
            'query'=> Answer::find()->andWhere(['user_guid'=>$model->user_guid])->orderBy('created_at desc'),
        ]);
        return $this->render('view-task', [
            'dataProvider' => $dataProvider,
            'model'=>$model
        ]);
    }
    
    public function actionGroup(){
        $dataProvider=new ActiveDataProvider([
            'query'=>Group::find()->andWhere(['create_by'=>yii::$app->user->identity->user_guid])->orderBy('created_at desc'),
        ]);
        return $this->render('group',[
            'dataProvider'=>$dataProvider
        ]);
    }
    
    public function actionCreateGroup(){
        $user_guid=yii::$app->user->identity->user_guid;
        $groupName=$_POST['group-name'];
        $group=new Group();
        $group->group_name=$groupName;
        $group->create_by=$user_guid;
        $group->created_at=time();
        if($group->save()){
            yii::$app->getSession()->setFlash('success','分组'.$groupName.'创建成功!');
        }else{
            yii::$app->getSession()->setFlash('error','分组'.$groupName.'创建失败!');
        }
        
        return  $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionViewGroup($id){
            $dataProvider=new ActiveDataProvider([
                'query'=>GroupUser::find()->andWhere(['group_id'=>$id])->orderBy('created_at desc'),
            ]);
        $group=Group::findOne($id);
        if(isset($_GET['name'])){
            $name=$_GET['name'];
        $userData=new ActiveDataProvider([
            'query'=>User::find()->andFilterWhere(['like', 'mobile', $name])->orderBy('created_at desc'),
            'pagination'=>[
                'pagesize'=>30
            ]
        ]);
        }else{
            $userData=new ActiveDataProvider([
                'query'=>User::find()->orderBy('created_at desc'),
                'pagination'=>[
                    'pagesize'=>30
                ]
            ]);
        }
        return $this->render('view-group',[
            'dataProvider'=>$dataProvider,
            'group'=>$group,
            'id'=>$id,
            'userData'=>$userData
        ]);
    }

    /**
     * 添加分组用户
     * @return \yii\web\Response
     */
    public function actionAddGroupUser(){
        $group_id=$_POST['groupid'];
        $users=$_POST['userid'];
        $i=0;
        foreach ($users as $k =>$v){
            $group=GroupUser::findOne(['user_guid'=>$v,'group_id'=>$group_id]);
            if(!empty($group)){
                continue;
            }
            $model=new GroupUser();
            $model->group_id=$group_id;
            $model->user_guid=$v;
            $model->created_at=time();
            if(!$model->save()){
                yii::$app->getSession()->setFlash('error','添加用户分组失败');
                continue;
            }
            $i++;
        }
        yii::$app->getSession()->setFlash('success','总共'.$i.'个用户添加分组成功!');
        return $this->redirect(['view-group','id'=>$group_id]);
    }
    
    public function actionDeleteGroupUser($id){
        GroupUser::findOne($id)->delete();
        yii::$app->getSession()->setFlash('success','用户已从当前分组移除!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionDeleteGroup($id){
        $group=Group::findOne($id);
        GroupUser::deleteAll(['group_id'=>$group->group_id]);
        $group->delete();
          yii::$app->getSession()->setFlash('success','分组已成功删除!');
          return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionEditGroup($id){
        $model=Group::findOne($id);
        if($model->load(yii::$app->request->post())&&$model->save()){
            return $this->redirect('group');
        }
        return $this->render('edit-group',[
            'model'=>$model
        ]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    //导出问题答案
    public function actionExportUser(){
       
        $users=User::find()->orderBy('created_at desc')->all();
    
    
        $resultExcel=new \PHPExcel();
        $resultExcel->getActiveSheet()->setCellValue('A1','序号');
        $resultExcel->getActiveSheet()->setCellValue('B1','姓名');
        $resultExcel->getActiveSheet()->setCellValue('C1','性别');
        $resultExcel->getActiveSheet()->setCellValue('D1','支付宝');
        $resultExcel->getActiveSheet()->setCellValue('E1','手机号');
        $resultExcel->getActiveSheet()->setCellValue('F1','邮箱');
        $resultExcel->getActiveSheet()->setCellValue('G1','地址');
        $resultExcel->getActiveSheet()->setCellValue('H1','身份证号');
        $resultExcel->getActiveSheet()->setCellValue('I1','年龄');
        $resultExcel->getActiveSheet()->setCellValue('J1','注册时间');
       
         
      
    
        $i=2;
        foreach ($users as $k=>$v){
            
                $resultExcel->getActiveSheet()->setCellValue('A'.$i,$k+1);
                $resultExcel->getActiveSheet()->setCellValue('B'.$i,$v['name']);
                $resultExcel->getActiveSheet()->setCellValue('C'.$i,$v['sex']);
                $resultExcel->getActiveSheet()->setCellValue('D'.$i,$v['alipay']);
                $resultExcel->getActiveSheet()->setCellValue('E'.$i,$v['mobile']);
                $resultExcel->getActiveSheet()->setCellValue('F'.$i,$v['email']);
                $resultExcel->getActiveSheet()->setCellValue('G'.$i,$v['address']);
                $resultExcel->getActiveSheet()->setCellValue('H'.$i,$v['identityno']);
                $resultExcel->getActiveSheet()->setCellValue('I'.$i,$v['age']);
                $resultExcel->getActiveSheet()->setCellValue('J'.$i,CommonUtil::fomatTime($v['created_at']));
              
    
                
                $i++;
    
            }
             
    
        
    
        //设置导出文件名
        $outputFileName ="随心赚用户".date('Y-m-d').'.xls';
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
    
    public function actionAdminUser(){
        
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
