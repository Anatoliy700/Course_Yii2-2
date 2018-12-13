<?php

namespace common\models;


use common\models\search\UserSearchNotInTeam;
use common\models\tables\Teams;
use common\models\tables\Users;
use yii\base\Model;
use yii\db\ActiveQuery;

class TeamOptions extends Model
{
    public $id;
    protected $userId;
    
    public function getTeam(){
        return Teams::findOne($this->id);
    }
    
    public function deleteUser($userId) {
        $this->userId = $userId;
        $team = Teams::find()
            ->from('teams t')
            ->where(['t.id' => $this->id])
            ->innerJoinWith(['users u' => function ($query) {
                /* @var ActiveQuery $query */
                $query->onCondition(['u.id' => $this->userId]);
            }])
            ->andWhere(['u.id' => $userId])
            ->one();
        
        if (!is_null($team)) {
            $team->unlink('users', $team->users[0], true);
        }
        return $team;
    }
    
    public function addUsers(array $usersId){
        $users = Users::findAll($usersId);
    
        if (count($users) > 0) {
            $team = Teams::findOne($this->id);
            foreach ($users as $user) {
                $team->link('users', $user);
            }
        }
        return count($users);
    }
    
    public function getUsersSearchNotInTeam() {
        return new UserSearchNotInTeam(['teamId' => $this->id]);
    }
}