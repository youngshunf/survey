<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $access_token
 * @property string $imei
 * @property string $imsi
 * @property string $name
 * @property integer $sex
 * @property string $password
 * @property string $province
 * @property string $city
 * @property string $nick
 * @property string $mobile
 * @property string $telephone
 * @property string $head_img
 * @property integer $score
 * @property string $address
 * @property string $email
 * @property string $age
 * @property string $birthday
 * @property string $created_at
 * @property string $updated_at
 * @property integer $id
 * @property string $path
 * @property string $photo
 * @property string $last_ip
 * @property string $last_login_time
 * @property string $last_login_client
 * @property string $user_guid
 * @property string $identityno
 * @property string $marital
 * @property string $interest
 * @property string $second_mobile
 * @property string $qq
 * @property string $weixin
 * @property string $homeland
 * @property string $bank_name
 * @property string $bank_account
 * @property string $alipay
 * @property string $top_edu
 * @property string $graduate_school
 * @property string $english_level
 * @property string $post
 * @property string $graduate_time
 * @property string $major
 * @property string $income_level
 * @property string $computer_level
 * @property string $work_experience
 * @property integer $children_age
 * @property integer $estate
 * @property string $home_income
 * @property integer $car_num
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score', 'created_at', 'updated_at', 'last_login_time',  'estate', 'car_num','enable'], 'integer'],
            [['user_guid','path','photo'], 'string'],
            [['access_token', 'imei', 'imsi', 'name', 'password', 'province', 'city', 'nick', 'email', 'age', 'birthday', 'bank_name', 'bank_account', 'alipay', 'major', 'income_level', 'computer_level'], 'string', 'max' => 64],
            [['mobile', 'telephone', 'weixin'], 'string', 'max' => 32],
            [['head_img', 'address', 'path', 'photo', 'last_login_client', 'interest', 'second_mobile', 'homeland', 'graduate_school', 'english_level', 'post', 'home_income'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 48],
            [['identityno', 'qq', 'graduate_time'], 'string', 'max' => 20],
            [['marital'], 'string', 'max' => 10],
            [['top_edu'], 'string', 'max' => 128],
            [['work_experience'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'access_token' => 'Access Token',
            'imei' => 'Imei',
            'imsi' => 'Imsi',
            'name' => '姓名',
            'sex' => '性别',
            'password' => '密码',
            'province' => '省份',
            'city' => '城市',
            'nick' => '昵称',
            'mobile' => '手机号',
            'telephone' => '电话',
            'head_img' => '头像',
            'score' => '积分',
            'address' => '地址',
            'email' => '邮箱',
            'age' => '年龄',
            'birthday' => '生日',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
            'id' => 'ID',
            'path' => 'Path',
            'photo' => 'Photo',
            'last_ip' => '最后登录IP',
            'last_login_time' => '最后登录时间',
            'last_login_client' => '最后登录客户端',
            'user_guid' => 'User Guid',
            'identityno' => '身份证号',
            'marital' => '婚姻状况',
            'interest' => '个人兴趣爱好',
            'second_mobile' => '备用手机号',
            'qq' => 'Qq',
            'weixin' => '微信',
            'homeland' => '籍贯',
            'bank_name' => '开户行',
            'bank_account' => '银行账号',
            'alipay' => '支付宝',
            'top_edu' => '最高学历',
            'graduate_school' => '毕业院校',
            'english_level' => '英语水平',
            'post' => '职业',
            'graduate_time' => '毕业时间',
            'major' => '所学专业',
            'income_level' => '个人收入(税后)',
            'computer_level' => '计算机能力',
            'work_experience' => '工作经历',
            'children_age' => '孩子年龄',
            'estate' => '自有房产数量',
            'home_income' => '家庭月收入(税后)',
            'car_num' => '私家车数量',
        ];
    }
    
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
