<?php

namespace common\models;


use common\models\search\TeamsSearch;
use common\models\search\UserSearchNotInTeam;
use common\models\tables\Teams;
use common\models\tables\Users;
use yii\base\Model;
use yii\db\ActiveQuery;

class TeamOptions extends Model
{
    public $id;
    protected $_userId;
    
    public function rules() {
        return [
            [['id'], 'integer', 'min' => 1]
        ];
    }
    
    public function getTeam() {
        if ($this->validate()) {
            return Teams::findOne($this->id);
        }
        return null;
    }
    
    public function deleteUser($userId) {
        
        if ($this->validate()) {
            $this->_userId = $userId;
            $team = Teams::find()
                ->from('teams t')
                ->where(['t.id' => $this->id])
                ->innerJoinWith(['users u' => function ($query) {
                    /* @var ActiveQuery $query */
                    $query->onCondition(['u.id' => $this->_userId]);
                }])
                ->andWhere(['u.id' => $userId])
                ->one();
            if (!is_null($team)) {
                $team->unlink('users', $team->users[0], true);
            }
            return $team;
        }
        return null;
    }
    
    public function addUsers(array $usersId) {
        
        if ($this->validate()) {
            $users = Users::findAll($usersId);
            if (count($users) > 0) {
                $team = Teams::findOne($this->id);
                foreach ($users as $user) {
                    $team->link('users', $user);
                }
            }
            return count($users);
        }
        return [];
    }
    
    public function getUsersSearchNotInTeam() {
        if ($this->validate()) {
            return new UserSearchNotInTeam(['teamId' => $this->id]);
        }
        return null;
    }
    
    public function getUserTeams($userId, $dataProviderType = false) {
        $dataProvider = (new TeamsSearch(['userId' => $userId]))->search(null);
        if ($dataProviderType) {
            return $dataProvider;
        }
        return $dataProvider->query->all();
    }
}