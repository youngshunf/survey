<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "score".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $score
 * @property string $score_code
 * @property string $score_desc
 * @property string $created_at
 */
class Score extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score', 'created_at'], 'integer'],
            [['score_desc'], 'string'],
            [['user_guid', 'score_code'], 'string', 'max' => 48]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => '用户guid',
            'score' => '积分',
            'score_code' => '积分编号',
            'score_desc' => '积分描述',
            'created_at' => '创建时间',
        ];
    }
}
