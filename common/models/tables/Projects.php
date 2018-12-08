<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProjectStatuses $status
 * @property Users $user
 * @property Tasks[] $tasks
 */
class Projects extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{projects}}';
    }
    
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'user_id', 'status_id'], 'required'],
            [['user_id', 'status_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectStatuses::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function fields() {
        return[
            'id',
            'name',
            'user' => 'username',
            'status' => 'statusName',
            'created_at',
            'updated_at',
        ];
    }
    
    public function getUsername(){
        return $this->user->username;
    }
    
    public function getStatusName(){
        return $this->status->name;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus() {
        return $this->hasOne(ProjectStatuses::className(), ['id' => 'status_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks() {
        return $this->hasMany(Tasks::className(), ['project_id' => 'id']);
    }
    
    public function getTasksComplete() {
        return $this
            ->hasMany(Tasks::className(), ['project_id' => 'id'])
            ->where(['status_id' => Tasks::STATUS_COMPLETE]);
    }
    
}
