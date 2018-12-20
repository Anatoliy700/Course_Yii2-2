<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\Users;
use yii\db\ActiveQuery;

/**
 * UserSearch represents the model behind the search form of `app\models\tables\Users`.
 */
class UsersInTeamSearch extends Users
{
    public $teamId;
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'role_id', 'teamId'], 'integer'],
            [['username', 'password_hash', 'first_name', 'last_name', 'email'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Users::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query
            ->joinWith('teams t')
            ->andWhere(['t.id' => $this->teamId]);
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
        ]);
        
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email]);
        
        return $dataProvider;
    }
}
