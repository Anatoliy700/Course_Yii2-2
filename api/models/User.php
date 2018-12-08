<?php

namespace api\models;


use yii\base\Model;

class User extends Model
{
    static public function authUser($username, $password) {
        $user = \common\models\User::findOne(['username' => $username]);
        if (is_null($user)) {
            return null;
        }
        return $user->validatePassword($password) ? $user : null;
    }
}