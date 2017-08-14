<?php

namespace frontend\controllers;

use Yii;
use common\models\Template;
use common\models\SearchTemplate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\TemplateQuestion;
use common\models\TaskTemplate;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
{
    public $enableCsrfValidation = false;
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

    /**
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTemplate();
        $searchModel->user_guid=yii::$app->user->identity->user_guid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTask()
    {
        $user_guid=yii::$app->user->identity->user_guid;
        $dataProvider = new ActiveDataProvider([
            'query'=>TaskTemplate::find()->andWhere(['user_guid'=>$user_guid])->orderBy('created_at desc')
        ]);
    
        return $this->render('task', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $dataProvider=new ActiveDataProvider([
            'query'=>TemplateQuestion::find()->andWhere(['templateno'=>$model->templateno])->orderBy('code asc'),
        ]);
        return $this->render('view', [
            'model' =>$model ,
            'dataProvider'=>$dataProvider
        ]);
    }
    
    public function actionViewTask($id)
    {
        $model=TaskTemplate::findOne($id);
        $dataProvider=new ActiveDataProvider([
            'query'=>TemplateQuestion::find()->andWhere(['templateno'=>$model->templateno])->orderBy('code asc'),
        ]);
        return $this->render('view-task', [
            'model' =>$model ,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Template model.
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

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
