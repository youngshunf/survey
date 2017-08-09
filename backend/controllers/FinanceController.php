<?php

namespace backend\controllers;

use common\models\IncomeRec;
use Yii;
use common\models\Wallet;
use common\models\SearchWallet;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\WithdrawRec;
use common\models\SearchWithdrawRec;
use common\models\Orders;
use common\models\AdminWallet;
use yii\filters\AccessControl;
use yii\db\Exception;


/**
 * FinanceController implements the CRUD actions for Wallet model.
 */
class FinanceController extends Controller
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
     * Lists all Wallet models.
     * @return mixed
     */
    public function actionIndex()
    {
        
       
        $searchModel = new SearchWithdrawRec();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $orders = new ActiveDataProvider([
            'query'=>Orders::find()->orderBy('created_at desc')
        ]);

        return $this->render('index', [
            'orders' => $orders,
            'dataProvider' => $dataProvider,
            'searchModel'=>$searchModel
        ]);
    }
    
    public function actionPayMoney($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $trans=yii::$app->db->beginTransaction();
        try{
            $wallet->paid +=$withDrawRec->amount;
            $wallet->withdrawing -=$withDrawRec->amount;
            $wallet->updated_at=time();
            if(!$wallet->save()) throw new Exception('');
            $withDrawRec->status=1;
            $withDrawRec->updated_at=time();
            if (!$withDrawRec->save()) throw new Exception('');
            $trans->commit();
            yii::$app->getSession()->setFlash('success','付款成功!');
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','付款失败!');
        }
        
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionRefusePay($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $trans=yii::$app->db->beginTransaction();
        try{
            $wallet->non_payment +=$withDrawRec->amount;
            $wallet->withdrawing -=$withDrawRec->amount;
            $wallet->updated_at=time();
            if(!$wallet->save()) throw new Exception('');
            $withDrawRec->status=99;
            $withDrawRec->updated_at=time();
            if (!$withDrawRec->save()) throw new Exception('');
            $trans->commit();
            yii::$app->getSession()->setFlash('success','驳回成功!');
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','驳回失败!');
        }
    
        return $this->redirect(yii::$app->request->referrer);
    }
    
    //会员财务
    public function actionMember()
    {
        $searchModel = new SearchWallet();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('member', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    //会员财务
    public function actionSpFinance()
    {
        $dataProvider = new ActiveDataProvider([
            'query'=>AdminWallet::find()->orderBy('created_at desc')
        ]);
    
        return $this->render('sp-finance', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wallet model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
       $model= $this->findModel($id);
        $dataProvider=new ActiveDataProvider([
            'query'=>IncomeRec::find()->andWhere(['user_guid'=>$model->user_guid])->orderBy('created_at desc'),
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider
        ]);
    }

   
    /**
     * Creates a new Wallet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wallet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wallet model.
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
     * Deletes an existing Wallet model.
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
     * Finds the Wallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Wallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
