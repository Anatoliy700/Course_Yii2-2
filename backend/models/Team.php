<?php

namespace backend\models;


use common\models\tables\Teams;
use yii\base\Model;

class Team extends Model
{
    static public function getCountTeams(){
        return Teams::find()->count();
    }
}