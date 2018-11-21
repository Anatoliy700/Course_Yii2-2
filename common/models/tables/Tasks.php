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
 * @property string $username
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 * @property Images $images
 */
class Tasks extends ActiveRecord
{
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
            [['title', 'description', 'date'], 'required'],
            [['user_id'], 'integer'],
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
            'created_at' => Yii::t('app/tables', 'Дата создания'),
            'updated_at' => Yii::t('app/tables', 'Дата обновления'),
        ];
    }
    
    public function fields() {
        return ['id', 'title', 'description', 'date'];
    }
    
    /**
     * @return object Users
     */
    public function getUser() {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
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
    
    static public function getArrAllTasks() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
    
}
