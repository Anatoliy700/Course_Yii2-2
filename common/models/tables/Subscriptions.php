<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "subscriptions".
 *
 * @property int $user_id
 * @property string $subscribe_name
 *
 * @property Users $user
 */
class Subscriptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'subscribe_name'], 'required'],
            [['user_id'], 'integer'],
            [['subscribe_name'], 'string', 'max' => 20],
            [['user_id', 'subscribe_name'], 'unique', 'targetAttribute' => ['user_id', 'subscribe_name']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'subscribe_name' => 'Subscribe Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    
    public function getChat(){
        return $this->hasOne(UserChat::class, ['user_id' => 'id'])->via('user');
    }
}
