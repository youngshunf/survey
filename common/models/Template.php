<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property string $id
 * @property string $name
 * @property string $user_guid
 * @property integer $is_auth
 * @property string $created_at
 * @property string $templateno
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guid'], 'string'],
            [['is_auth', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['templateno'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '模板名称',
            'user_guid' => 'User Guid',
            'is_auth' => '是否审核',
            'created_at' => '创建时间',
            'templateno' => '模板编号',
        ];
    }
    
    public static function createTemplateno(){
        return 'T'.date('Ymdhis').rand(1000, 9999);
    }
    
   
}
