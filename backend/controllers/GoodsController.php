<?php

namespace backend\controllers;

use Yii;
use common\models\Goods;
use common\models\SearchGoods;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\GoodsCate;
use common\models\CommonUtil;
use common\models\ImageUploader;
use common\models\Shop;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action){
        $this->layout='@app/views/layouts/goods_layout.php';
        
        return parent::beforeAction($action);
    }

    /**
     * 商品分类
     * @return mixed
     */
    public function actionIndex()
    {
        
        $dataProvider =new ActiveDataProvider([
            'query'=>GoodsCate::find()->orderBy("created_at desc"),
            
        ]);

    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionGoods()
    {
        
        $searchModel = new SearchGoods();
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $cate=GoodsCate::findOne($id);
            $searchModel->cate_guid=$cate->cate_guid;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        $this->layout='@app/views/layouts/goods_layout.php';
        return $this->render('goods', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,       
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Goods();
      
        if ($model->load(Yii::$app->request->post())) {
            $model->goods_guid=CommonUtil::createUuid();
            $model->create_by=yii::$app->user->identity->user_guid;
            $model->create_type=1;
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->end_time=strtotime($model->end_time);
            $model->desc=@$_POST['desc'];
            $model->created_at=time();
            if($model->save())
              return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $cates=GoodsCate::find()->all();
            $shop=Shop::find()->all();
            return $this->render('create', [
                'model' => $model,
                'cates'=>$cates,
                'shop'=>$shop
            ]);
        }
    }
    
    public function actionCreateCate()
    {
 
        $model = new GoodsCate();
    
        if ($model->load(Yii::$app->request->post()) ) { 
            $model->cate_guid=CommonUtil::createUuid();
            $model->create_by=yii::$app->user->identity->user_guid;    
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->created_at=time();
            if($model->save())
                 return $this->redirect(['view-cate', 'id' => $model->id]);
        } else {
            return $this->render('create-cate', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionViewCate($id)
    {
        $model=GoodsCate::findOne($id);
        return $this->render('view-cate', [
            'model' =>$model,
        ]);
    }
    
    public function actionUpdateCate($id)
    {
        $model = GoodsCate::findOne($id);
    
        if ($model->load(Yii::$app->request->post()) ) {
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['view-cate', 'id' => $model->id]);
    
        } else {
             
            return $this->render('update-cate', [
                'model' => $model,
                 
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->end_time=date('Y-m-d H:i',$model->end_time);
        if ($model->load(Yii::$app->request->post()) ) {
          
            $model->create_by=yii::$app->user->identity->user_guid;

            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->desc=@$_POST['desc'];
            $model->end_time=strtotime($model->end_time);
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $cates=GoodsCate::find()->all();
            $shop=Shop::find()->all();
            return $this->render('update', [
                'model' => $model,
                'cates'=>$cates,
                'shop'=>$shop
            ]);
        }
    }

    /**
     * Deletes an existing Goods model.
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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
