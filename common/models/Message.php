<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property string $from_user
 * @property string $to_user
 * @property string $content
 * @property integer $type
 * @property string $created_at
 * @property string $title
 * @property integer $is_read
 */
class Message extends \yii\db\ActiveRecord
{
    const SYS=1;
    const USER=2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user', 'to_user', 'content'], 'string'],
            [['type', 'created_at', 'is_read'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user' => 'From User',
            'to_user' => 'To User',
            'content' => '消息内容',
            'type' => '消息类型',
            'created_at' => 'Created At',
            'title' => '标题',
            'is_read' => '是否已读',
        ];
    }
    
    public function sendMessage($fromUser=null,$toUser,$title=null,$content,$type=1){
        $message= new Message();
        if($fromUser==null){
            $message->from_user="eb3a4eba-8a87-11e4-8ef2-201a065c562d";
        }else{
            $message->from_user=$fromUser;
        }
        $message->to_user=$toUser;
        if($title!=null){
            $message->title=$title;
        }
        $message->content=$content;
        $message->type=$type;
        $message->created_at=time();
        if($message->save()){
            return true;
        }
        
        return false;
        
    }
    
}
