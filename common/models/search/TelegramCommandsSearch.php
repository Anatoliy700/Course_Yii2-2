<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\TelegramCommands;

/**
 * TelegramCommandsSearch represents the model behind the search form of `common\models\tables\TelegramCommands`.
 */
class TelegramCommandsSearch extends TelegramCommands
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['update_id', 'chat_id', 'done', 'date'], 'integer'],
            [['command', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = TelegramCommands::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'update_id' => $this->update_id,
            'chat_id' => $this->chat_id,
            'done' => $this->done,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'command', $this->command]);

        return $dataProvider;
    }
}
