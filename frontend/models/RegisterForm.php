<?php
namespace frontend\models;

use yii\base\Model;
use common\models\CommonUtil;
use common\models\AdminUser;
use common\models\MobileVerify;


/**
 * Register form
 */
class RegisterForm extends Model
{
    public $username;
    public $email;
    public $mobile;
    public $password;
    public $password2;
    

    public function rules()
    {
        return [
          
            [['email', 'password','password2','username','mobile'], 'required'],        
          // 邮箱验证
            ['email', 'email', 'message'=>'请输入正确的邮箱'],
          //验证用户名是否注册
           	['username', 'unique','targetClass' => '\common\models\AdminUser', 'message' => '此用户名已经被使用'],         
            ['password', 'string', 'max'=>22, 'min'=>6, 'tooLong'=>'密码请输入长度为6-22位字符', 'tooShort'=>'密码请输入长度为6-22位字符'],          
            //验证邮箱是否注册
            ['email', 'unique','targetClass' => '\common\models\AdminUser', 'message'=>'邮箱已存在'], 
            ['mobile', 'unique','targetClass' => '\common\models\AdminUser', 'message' => '该手机号已注册'],
            // 验证两次输入的密码是否一致
            ['password2', 'compare', 'compareAttribute'=>'password','message'=>'两次密码不一致'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password2' => '确认密码',
            'password' => '密码',
            'mobile' => '手机号',
            'email' => '邮箱',
            'username'=>'用户名'
        ];
    }

    /**
     * 注册
     *
     */
    public function register()
    {
        $mobileVerify=MobileVerify::findOne(['mobile'=>$this->mobile,'verify_code'=>$_POST['verify_code'],'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
            yii::$app->getSession()->setFlash('error','注册失败,验证码错误!');
            return false;
        }
        	$user= new AdminUser();
        	$user->username=$this->username;
        	$user->user_guid=CommonUtil::createUuid();
        	$user->email=$this->email;
        	$user->mobile=$this->mobile;
        	$user->role_id=89;
        	$user->generateAuthKey();
        	$user->setPassword($this->password);
        	$user->generateAuthKey();
        	$user->created_at=time();
        	$user->password=md5($this->password);       	       	
             $user->password_origin=$this->password;  
        	if($user->save()){
        		    return true;
        		}     
        		yii::$app->getSession()->setFlash('error','注册失败,服务器错误!');
        	return false;
    }
}
