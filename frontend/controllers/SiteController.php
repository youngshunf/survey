<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\Task;
use common\models\User;
use frontend\models\RegisterForm;
use frontend\models\LoginForm;
use common\models\MobileVerify;
use common\models\CommonUtil;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'register','error','send-verify-code'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 发送验证码
     * @author youngshunf
     * @return string
     */
    public function actionSendVerifyCode(){
    
        $mobile=$_POST['mobile'];
        //$mobile='18611348367';
        $verifyCode=rand(1000,9999);
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            return CommonUtil::error('e1004');
        }
    
        $mobileVerify=new MobileVerify();
        $mobileVerify->mobile=$mobile;
        $mobileVerify->verify_code=$verifyCode;
        $mobileVerify->created_at=time();
        if($mobileVerify->save()){
            $this->sendSMS($mobile, $verifyCode);
            return CommonUtil::success('sent');
        }
    
        return CommonUtil::error('e1002');
    
    }
    
    public  function sendSMS($mobile,$code){
        $c = new \TopClient;
        $c ->appkey = '23465743' ;
        $c ->secretKey = 'ee102020bf40eca0f499dfd3d246367a';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "索信随心赚" );
        $param=[
            'code'=>(string)$code
        ];
        $param=json_encode($param);
        $req ->setSmsParam( $param );
        $req ->setRecNum( $mobile );
        $req ->setSmsTemplateCode( "SMS_16665990" );
        $resp = $c ->execute( $req );
    }
    public function actionIndex()
    {
        $user_guid=yii::$app->user->identity->user_guid;
        $total_task=Task::find()->andWhere(['user_guid'=>$user_guid])->count();
        $total_price=Task::find()->andWhere(['user_guid'=>$user_guid])->sum('total_price');
        $total_user=User::find()->andWhere(['user_guid'=>$user_guid])->count();
        $total_view=Task::find()->andWhere(['user_guid'=>$user_guid])->sum('count_view');
        return $this->render('index',
            [
                'total_task'=>$total_task,
                'total_price'=>$total_price,
                'total_user'=>$total_user,
                'total_view'=>$total_view
            ]
            );
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goHome();
        } else {
         
            return $this->renderAjax('register', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
