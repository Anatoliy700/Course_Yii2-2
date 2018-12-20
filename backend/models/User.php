<?php

namespace backend\models;


use common\models\tables\Users;
use yii\base\Model;

class User extends Model
{
    static public function getCountAllUsers() {
        return Users::find()->count();
    }
    
    static public function getCountUsersInTeams() {
        return Users::find()
            ->innerJoinWith('teamUser tu')
            ->groupBy('tu.user_id')
            ->count();
    }
    
    static public function getStatisticUsers() {
        $all = static::getCountAllUsers();
        $inTeams = static::getCountUsersInTeams();
        return [
            'all' => (int)$all,
            'inTeams' => (int)$inTeams,
            'free' => $all - $inTeams
        ];
    }
}