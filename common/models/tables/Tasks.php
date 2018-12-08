<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property int $user_id
 * @property int $status_id
 * @property int $project_id
 * @property string $username
 * @property Projects $project
 * @property TaskStatuses $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 * @property Images $images
 */
class Tasks extends ActiveRecord
{
    const STATUS_COMPLETE = 2;
    const STATUS_IN_WORK = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tasks';
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
            [['title', 'description', 'date', 'status_id', 'project_id'], 'required'],
            [['user_id', 'status_id', 'project_id'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['username'], 'safe']
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => Yii::t('app/tables', 'Заголовок'),
            'description' => Yii::t('app/tables', 'Описание'),
            'date' => Yii::t('app/tables', 'Дата'),
            'user_id' => Yii::t('app/tables', 'Пользователь'),
            'username' => Yii::t('app/tables', 'Пользователь'),
            'status_id' => Yii::t('app/tables', 'Статус'),
            'project_id' => Yii::t('app/tables', 'Проект'),
            'created_at' => Yii::t('app/tables', 'Дата создания'),
            'updated_at' => Yii::t('app/tables', 'Дата обновления'),
            'projectName' => Yii::t('app/tables', 'Проект'),
            'statusName' => Yii::t('app/tables', 'Статус'),
        ];
    }
    
    public function fields() {
        return [
            'id',
            'title',
            'description',
            'date',
            'status' => 'statusName',
            'user' => 'username',
            'project' => 'projectName',
            'created_at',
            'updated_at',
            ];
    }
    
    /**
     * @return object Users
     */
    public function getUser() {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
    
    public function getProject() {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }
    
    public function getStatus() {
        return $this->hasOne(TaskStatuses::class, ['id' => 'status_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages() {
        return $this->hasMany(Images::class, ['task_id' => 'id']);
    }
    
    public function getUsername() {
        return $this->user->username;
    }
    
    public function getProjectName(){
        return $this->project->name;
    }
    
    public function getStatusName(){
        return $this->status->name;
    }
    
    static public function getArrAllTasks() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
    
}
