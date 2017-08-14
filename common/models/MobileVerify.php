<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mobile_verify".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $verify_code
 * @property integer $is_valid
 * @property string $created_at
 */
class MobileVerify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_verify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [       
    /*         [['mobile'], 'string', 'max' => 20],
            [['verify_code'], 'string', 'max' => 10] */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'verify_code' => 'Verify Code',
            'is_valid' => '是否有效',
            'created_at' => 'Created At',
        ];
    }
}
