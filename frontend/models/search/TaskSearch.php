<?php

namespace frontend\models\search;

use common\models\tables\Users;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\Tasks;

/**
 * TaskSearch represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TaskSearch extends Tasks
{
    
    public $pageSize;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'status_id', 'project_id'], 'integer'],
            [['title', 'description', 'date', 'username'], 'safe'],
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
        $query = Tasks::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize
            ]
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->with('user');
        $query->with('project');
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'date' => $this->date,
            'user_id' => $this->user_id,
            'project_id' => $this->project_id,
            'status_id' => $this->status_id,
        ]);
        
        $query->andFilterWhere(['like', 'date', "{$this->date}"]);
        
        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);
        
        return $dataProvider;
    }
    
    public function getUser() {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
    
    public function setUsername($username) {
        $user = Users::find()->where(['username' => $username])->one();
        if (!is_Null($user)) {
            $this->user_id = $user->id;
        }
    }
    
}
