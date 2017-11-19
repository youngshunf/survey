<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_rec".
 *
 * @property string $id
 * @property string $user_guid
 * @property string $ip
 * @property string $time
 * @property string $ua
 * @property string $lng
 * @property string $lat
 */
class LoginRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'string'],
            [['time'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['ua', 'lng', 'lat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'ip' => 'Ip',
            'time' => 'Time',
            'ua' => 'Ua',
            'lng' => 'Lng',
            'lat' => 'Lat',
        ];
    }
    
    public function getAdminuser(){
        return $this->hasOne(AdminUser::className(), ['user_guid'=>'user_guid']);
    }
}
