<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\CommonUtil;
use common\models\SMS;
use common\models\MobileVerify;
use common\models\LoginRec;


/**
 *app api
 */
class SiteController extends Controller
{
 

    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
    
    public function beforeAction($action){

        if($action!='check-update'){
            //检查客户端是否提交数据
            if(!isset($_POST['data'])){
                return CommonUtil::error('e1001');
            }
        }
        
        if($action!='check-update'||$action!='login'||$action!='check-mobile' || $action!='register' ||$action!='check-username'){
            //检查用户是否登录
            if(!isset($_POST['user'])){
                return CommonUtil::error('e1001');
            }
        }
        
        return parent::beforeAction($action);
    }
    
    /**
     * 检查手机号是否注册
     * @return string
     */
    public function actionCheckMobile(){
   
        $data=$_POST['data'];
        $mobile=$data['mobile'];      
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            return CommonUtil::error('e1004');
        }        
        return CommonUtil::success('checked');
    }
    
    /**
     * 检查用户名是否注册
     * @return string
     */
    public function actionCheckUsername(){
         
        $data=$_POST['data'];
        $username=$data['username'];
        $user=User::findOne(['username'=>$username]);
        if(!empty($user)){
            return CommonUtil::error('e1004');
        }
        return CommonUtil::success('checked');
    }
    
    
    
    /**
     * 发送验证码
     * @author youngshunf
     * @return string
     */    
    public function actionSendVerifyCode(){
      
        $data=$_POST['data'];
        $mobile=$data['mobile'];
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
            SMS::sendSingleSMS($mobile, "感谢您注册问卷调研,您的验证码为:".$verifyCode.",为了您的账号安全,请不要透露给其他人.【问卷调研】");
            return CommonUtil::success('sent');
        }
        
       return CommonUtil::error('e1002');

    }
    
    /**
     * 修改密码验证码
     * @author youngshunf
     * @return string
     */
    public function actionSendVerifyCode2(){
        if(!isset($_POST['data'])){
            return CommonUtil::error('e1001');
        }
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $verifyCode=rand(1000,9999);
        $user=User::findOne(['mobile'=>$mobile]);
        if(empty($user)){
            return CommonUtil::error('e1004');
        }
    
        $mobileVerify=new MobileVerify();
        $mobileVerify->mobile=$mobile;
        $mobileVerify->verify_code=$verifyCode;
        $mobileVerify->created_at=time();
        if($mobileVerify->save()){
            SMS::sendSingleSMS($mobile, "您的验证码为:".$verifyCode.",为了您的账号安全,请不要透露给其他人.【随心赚】");
            return CommonUtil::success('sent');
        }
        return CommonUtil::error('e1002');
    
    }
    
    /**
     * 修改密码
     * @author youngshunf
     */
    public function actionChangePassword(){
        if(!isset($_POST['data'])){
            return CommonUtil::error('e1001');
        }
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
            return CommonUtil::error('e1003');
        }
         
        $user=User::findOne(['mobile'=>$mobile]);
        if(empty($user)){
            //用户手机未注册
            return CommonUtil::error('e1004');
        }
    
        $user->password=md5($password);
        $user->generateAccessToken();
        $user->updated_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
            //记录登录日志
            $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=$user->last_login_time;
            $loginRec->ua=$user->last_login_client;
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    
    }
    /**
     * 用户注册
     * @author youngshunf
     */
    public function actionRegister(){
      
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
           return CommonUtil::error('e1003');     
        }
    
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            //用户手机已注册
           return CommonUtil::error('e1004');     
        }
                
        $user=new User();
        $user->user_guid=CommonUtil::createUuid();
        $user->mobile=$mobile;
        $user->password=md5($password);
        $user->imei=@$data['deviceInfo']['imei'];
        $user->imsi=@$data['deviceInfo']['imsi'];
        $user->generateAccessToken();
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_login_time=time();
        $user->last_login_client=yii::$app->request->getUserAgent();
        $user->created_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
            
            //自动登录
            $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=$user->last_login_time;
            $loginRec->ua=$user->last_login_client;
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
            
           return CommonUtil::success($user);
        }        
       return CommonUtil::error('e1002');     
        
    }
    
    /**
     * 用户自动登陆
     */
    public function actionAutoLogin(){
     $clientUser=$_POST['user'];
    //验证用户
    $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
            if(empty($user)){
                return CommonUtil::error('e1006');
       }
       // $user->generateAccessToken();
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_login_time=time();
        $user->last_login_client=yii::$app->request->getUserAgent();
        
        if($user->save()){      
             $loginRec=new LoginRec();
             $loginRec->user_guid=$user->user_guid;
             $loginRec->ip=$user->last_ip;
             $loginRec->time=$user->last_login_time;
             $loginRec->ua=$user->last_login_client;
             $loginRec->lng=@$_POST['data']['locInfo']['lng'];
             $loginRec->lat=@$_POST['data']['locInfo']['lat'];
             $loginRec->address=@$_POST['data']['locInfo']['address'];  
             $loginRec->save();  
           return CommonUtil::success($user);     
        }
        
        return CommonUtil::error('e1005');
    }
    
    /**
     *用户登录
     *@author youngshunf
     */
    public function actionLogin()
    {       
        
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=md5($data['password']);  
              
        $user=User::find()->andWhere(" mobile ='$mobile' and password='$password' ")->one();            
        if($user===null){
            return CommonUtil::error('e1005');
        }   
       // $user->generateAccessToken();
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_login_time=time();
        $user->last_login_client=yii::$app->request->getUserAgent();
        if($user->save()){          
             $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=$user->last_login_time;
            $loginRec->ua=$user->last_login_client;
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
           return CommonUtil::success($user);     
        }
        
        return CommonUtil::error('e1005');
    }    
    

    /**
     * 检查更新
     * @author youngshunf
     * @return string
     *
     */
    public function actionCheckUpdate(){
       
      $updateInfo=[
          'newVer'=>'1.1.2',
          'wgtUrl'=>'http://upload-survey.mi2you.com/wgt/H55174E5A.wgt'
      ];
      
      return json_encode($updateInfo);
        
    
    
    }

}
