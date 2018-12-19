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
 * @property int $initiator_id
 * @property string $username
 * @property string initiatorName
 * @property Projects $project
 * @property TaskStatuses $status
 * @property string $done_date
 * @property string $report
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 * @property Users $initiator
 * @property Images $images
 */
class Tasks extends ActiveRecord
{
    const STATUS_COMPLETE = 2;
    const STATUS_IN_WORK = 1;
    const SCENARIO_COMPLETE = 'complete';
    
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
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_COMPLETE] = ['report', 'status_id', 'done_date'];
        return $scenarios;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'description', 'date', 'status_id', 'project_id', 'initiator_id'], 'required'],
            [['user_id', 'status_id', 'project_id', 'initiator_id'], 'integer'],
            [['date', 'done_date', 'username', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
            [['initiator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['initiator_id' => 'id']],
            [['report'], 'required', 'on' => static::SCENARIO_COMPLETE],
            [['report'], 'string', 'min' => 2, 'on' => static::SCENARIO_COMPLETE],
            [['report'], 'string', 'max' => 255, 'on' => static::SCENARIO_COMPLETE],
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
            'date' => Yii::t('app/tables', 'Дедлайн'),
            'user_id' => Yii::t('app/tables', 'Пользователь'),
            'username' => Yii::t('app/tables', 'Исполнитель'),
            'status_id' => Yii::t('app/tables', 'Статус'),
            'project_id' => Yii::t('app/tables', 'Проект'),
            'initiator_id' => Yii::t('app/tables', 'Инициатор'),
            'initiatorName' => Yii::t('app/tables', 'Инициатор'),
            'done_date' => Yii::t('app/tables', 'Дата закрытия задачи'),
            'created_at' => Yii::t('app/tables', 'Дата создания'),
            'updated_at' => Yii::t('app/tables', 'Дата обновления'),
            'projectName' => Yii::t('app/tables', 'Проект'),
            'statusName' => Yii::t('app/tables', 'Статус'),
            'report' => Yii::t('app/tables', 'Отчет'),
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
            'initiator' => 'initiatorName',
            'done_date',
            'report',
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
    
    /**
     * @return object Users
     */
    public function getInitiator() {
        return $this->hasOne(Users::class, ['id' => 'initiator_id']);
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
    
    public function getInitiatorName() {
        return $this->initiator->username;
    }
    
    public function getProjectName() {
        return $this->project->name;
    }
    
    public function getStatusName() {
        return $this->status->name;
    }
    
    static public function getArrAllTasks() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
    
}
