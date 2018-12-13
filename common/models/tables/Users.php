<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property int $role_id
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tasks[] $tasks
 * @property Roles $role
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'users';
    }
    
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'password_hash', 'first_name', 'last_name', 'role_id', 'email'], 'required'],
            [['role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'first_name', 'last_name', 'email'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => Yii::t('app/tables', 'Имя пользователя'),
            'password_hash' => Yii::t('app/tables', 'Пароль'),
            'first_name' => Yii::t('app/tables', 'Имя'),
            'last_name' => Yii::t('app/tables', 'Фамилия'),
            'role_id' => Yii::t('app/tables', 'Роль'),
            'email' => 'Email',
            'created_at' => Yii::t('app/tables', 'Дата создания'),
            'updated_at' => Yii::t('app/tables', 'Дата обновления'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks() {
        return $this->hasMany(Tasks::className(), ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUser() {
        return $this->hasMany(TeamsUsers::class, ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams() {
        return $this->hasMany(TeamsUsers::class, ['user_id' => 'id'])
            ->via('teamUser');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole() {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions() {
        return $this->hasMany(Subscriptions::class, ['user_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChat() {
        return $this->hasOne(UserChat::class, ['id' => 'user_id']);
    }
    
    static public function getUsersSelect() {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }
}
