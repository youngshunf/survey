<?php

namespace app\models;

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
            [['sex', 'score', 'created_at', 'updated_at', 'last_login_time', 'children_age', 'estate', 'car_num'], 'integer'],
            [['user_guid'], 'string'],
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
            'name' => 'Name',
            'sex' => 'Sex',
            'password' => 'Password',
            'province' => 'Province',
            'city' => 'City',
            'nick' => 'Nick',
            'mobile' => 'Mobile',
            'telephone' => 'Telephone',
            'head_img' => 'Head Img',
            'score' => 'Score',
            'address' => 'Address',
            'email' => 'Email',
            'age' => 'Age',
            'birthday' => 'Birthday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id' => 'ID',
            'path' => 'Path',
            'photo' => 'Photo',
            'last_ip' => 'Last Ip',
            'last_login_time' => 'Last Login Time',
            'last_login_client' => 'Last Login Client',
            'user_guid' => 'User Guid',
            'identityno' => 'Identityno',
            'marital' => 'Marital',
            'interest' => 'Interest',
            'second_mobile' => 'Second Mobile',
            'qq' => 'Qq',
            'weixin' => 'Weixin',
            'homeland' => 'Homeland',
            'bank_name' => 'Bank Name',
            'bank_account' => 'Bank Account',
            'alipay' => 'Alipay',
            'top_edu' => 'Top Edu',
            'graduate_school' => 'Graduate School',
            'english_level' => 'English Level',
            'post' => 'Post',
            'graduate_time' => 'Graduate Time',
            'major' => 'Major',
            'income_level' => 'Income Level',
            'computer_level' => 'Computer Level',
            'work_experience' => 'Work Experience',
            'children_age' => 'Children Age',
            'estate' => 'Estate',
            'home_income' => 'Home Income',
            'car_num' => 'Car Num',
        ];
    }
}
