<?php

namespace common\models\search;


use common\models\tables\Users;
use yii\data\ActiveDataProvider;

class UserSearchNotInTeam extends Users
{
    public $teamId;
    
    public function rules() {
        return [
            [['username', 'first_name', 'last_name'], 'safe'],
        ];
    }
    
    
    public function search($params) {
        $query = Users::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $query->andWhere("id not in (select user_id from teams_users where team_id = {$this->teamId})");
        
        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);
        
        return $dataProvider;
    }
}