<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "telegram_commands".
 *
 * @property int $update_id
 * @property string $command
 * @property int $chat_id
 * @property int $done
 * @property int $date
 * @property string $created_at
 * @property string $updated_at
 */
class TelegramCommands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{telegram_commands}}';
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
    public function rules()
    {
        return [
            [['update_id', 'command', 'chat_id', 'date'], 'required'],
            [['update_id', 'chat_id', 'done', 'date'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['command'], 'string', 'max' => 20],
            [['update_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'update_id' => 'Update ID',
            'command' => 'Command',
            'chat_id' => 'Chat ID',
            'done' => 'Done',
            'date' => 'Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
