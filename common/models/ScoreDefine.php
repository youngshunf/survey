<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "score_define".
 *
 * @property integer $id
 * @property integer $score
 * @property string $score_code
 * @property string $score_desc
 */
class ScoreDefine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'score_define';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score'], 'integer'],
            [['score_desc'], 'string'],
            [['score_code'], 'string', 'max' => 48]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'score' => '积分',
            'score_code' => '积分编号',
            'score_desc' => '积分描述',
        ];
    }
}
