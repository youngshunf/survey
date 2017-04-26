<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\ImageUploader;
use yii\filters\AccessControl;
use common\models\HomePhoto;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class SystemController extends Controller
{
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
    
    public function beforeAction($action){
        $this->layout='@app/views/layouts/system_layout.php';
        
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $dataProvider =new ActiveDataProvider([
            'query'=>HomePhoto::find()->orderBy('created_at desc'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateHomePhoto()
    {
  
        $model = new HomePhoto();
      
        if ($model->load(Yii::$app->request->post())) {
            $model->create_by=yii::$app->user->identity->user_guid;
 
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }       
            $model->created_at=time();
            if($model->save())
              return $this->redirect(['view-photo', 'id' => $model->id]);
        } else {
            return $this->render('create-home-photo', [
                'model' => $model,
    
            ]);
        }
    }
    
    public function actionViewPhoto($id){
        $model=HomePhoto::findOne($id);
        $this->layout='@app/views/layouts/system_layout.php';
        return $this->render('view-photo',['model'=>$model]);
    }
    
    public function actionUpdatePhoto($id)
    {
        $this->layout='@app/views/layouts/system_layout.php';
        $model = HomePhoto::findOne($id);
    
        if ($model->load(Yii::$app->request->post())) {
            $model->create_by=yii::$app->user->identity->user_guid;
    
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['view-photo', 'id' => $model->id]);
        } else {
            return $this->render('create-home-photo', [
                'model' => $model,
    
            ]);
        }
    }
    
    public function actionDeletePhoto($id){
        HomePhoto::findOne($id)->delete();
         return $this->redirect('index');
    }
    



}
