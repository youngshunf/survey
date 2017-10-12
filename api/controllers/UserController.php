<?php
namespace api\controllers;

use common\models\WithdrawRec;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use common\models\User;
use yii\helpers\Json;
use common\models\CommonUtil;
use common\models\SMS;
use common\models\FoursInfo;
use common\models\Score;
use common\models\MobileVerify;
use common\models\ImageUploader;
use common\models\Wallet;
use common\models\Answer;
use common\models\Message;

/**
 * 用户信息
 */
class UserController extends Controller
{


    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
    
    public function actionIndex(){

        return $this->render('index');
                      
    }
         
    
        /**
     * 修改个人信息
     * @author youngshunf
     *
     */
    public function actionUpdateProfile(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->name=@$data['name'];
        $user->sex=@$data['sex'];
        $user->birthday=@$data['birthday'];
        $user->identityno=@$data['identityno'];
        $user->address=@$data['address'];
        $user->email=@$data['email'];
        $user->bank_name=@$data['bank_name'];
        $user->bank_account=@$data['bank_account'];
        $user->marital=@$data['marital'];
        $user->interest=@$data['interest'];
        $user->second_mobile=@$data['second_mobile'];
        $user->homeland=@$data['homeland'];
        $user->weixin=@$data['weixin'];
        $user->qq=@$data['qq'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
        
        
    }
    
    /**
     * 修改个人学历与职业
     * @author youngshunf
     *
     */
    public function actionUpdatePost(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->top_edu=@$data['top_edu'];
        $user->graduate_school=@$data['graduate_school'];
        $user->graduate_time=@$data['graduate_time'];
        $user->english_level=@$data['english_level'];
        $user->major=@$data['major'];
        $user->computer_level=@$data['computer_level'];
        $user->post=@$data['post'];
        $user->income_level=@$data['income_level'];
        $user->work_experience=@$data['work_experience'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    
    }
    /**
     * 修改家庭信息
     * @author youngshunf
     *
     */
    public function actionUpdateHomeInfo(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->children_age=@$data['children_age'];
        $user->home_income=@$data['home_income'];
        $user->estate=@$data['estate'];
        $user->car_num=@$data['car_num'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        
        return CommonUtil::error('e1002');
        
    }
    /**
     * 上传头像
     * @author youngshunf
     * 
     */
  public function actionUploadHeadimg(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $imgData=@$_POST['data']['imgData'];
        $imgLen=@$_POST['data']['imgLength'];
        $photo=ImageUploader::uploadHeadImageByBase64($imgData, $imgLen);
        if($photo){
            $user->path=$photo['path'];
            $user->photo=$photo['photo'];
            $user->updated_at=time();
            if($user->save()){
                return CommonUtil::success($user);
            }
         }
        
         return CommonUtil::error('e1002');
    }
       
   public function actionCheckAccount(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       
       $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
       if(empty($wallet)){
           $amount='0.00';
       }else{
           $amount=$wallet['non_payment'];
       }
       $unsubmit=Answer::find()->andWhere(['user_guid'=>$user->user_guid,'status'=>1])->count();
       $unauth=Answer::find()->andWhere(['user_guid'=>$user->user_guid,'status'=>2])->count();
       $pass=Answer::find()->andWhere(['user_guid'=>$user->user_guid,'status'=>3])->count();
       $deny=Answer::find()->andWhere(['user_guid'=>$user->user_guid,'status'=>99])->count();
       $result=[
           'amount'=>$amount,
           'unsubmit'=>$unsubmit,
           'unauth'=>$unauth,
           'pass'=>$pass,
           'deny'=>$deny
       ];
       return CommonUtil::success($result);
   }      

   public function actionGetWallet(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
       if(empty($wallet)){
           return CommonUtil::success('nodata');
       }
       return CommonUtil::success($wallet);
   
   }
   
  /**
   * 获取未读消息
   * @return string
   */
     public function actionGetMessageState(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $unreadSys=Message::find()->andWhere(['to_user'=>$user->user_guid,'is_read'=>0,'type'=>Message::SYS])->count();
       $unreadEnt=Message::find()->andWhere(['to_user'=>$user->user_guid,'is_read'=>0,'type'=>2])->count();
        
       $result=[
           'unreadSys'=>$unreadSys,
           'unreadEnt'=>$unreadEnt
       ];
       return CommonUtil::success($result);
   }
   
   /**
    * 获取未读消息
    * @return string
    */
   public function actionGetNotify(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $type=@$_POST['type'];
       $notify=Message::find()->andWhere(['to_user'=>$user->user_guid,'type'=>$type])->orderBy('created_at desc')->all();
        Message::updateAll(['is_read'=>1],['to_user'=>$user->user_guid,'type'=>$type]);
       return $this->renderAjax('notify',[
           'notify'=>$notify
       ]);
   }

   
    /**
     * 更新支付宝信息
     * @author youngshunf
     * @return string
     *
     */

    public function actionUpdateAlipay(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->alipay=$data['alipay'];
        if($user->save()){
            return CommonUtil::success($user);
        }

        return CommonUtil::error('e1002');
    }
    
    public function actionUpdateName(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->name=$data['name'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }

    /**
     * 申请提现
     * @author youngshunf
     * @return string
     *
     */

    public function actionWithDraw(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $amount=$data['amount'];
        $trans=yii::$app->db->beginTransaction();
        $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
        if($amount<=0){
            return CommonUtil::success('提现金额不能小于0');
        }
        if($amount>$wallet->non_payment){
            return CommonUtil::success('提现金额不能大于余额');
        }
        try{
            $withDrawRec=new WithdrawRec();
            $withDrawRec->user_guid=$user->user_guid;
            $withDrawRec->amount=$amount;
            $withDrawRec->created_at=time();

            if(!$withDrawRec->save()) throw new Exception();
                
                $wallet->non_payment -= $amount;
                $wallet->withdrawing += $amount;
            if(!$wallet->save()) throw new Exception();
            $trans->commit();
             return CommonUtil::success('success');

        }catch(Exception $e){
            $trans->rollBack();
            return CommonUtil::error('e1002');
        }



    }




}
