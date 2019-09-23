<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;
use yii\data\Sort;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'projectId', 'typeId', 'priority', 'authorId', 'executorId', 'status'], 'integer'],
            [['name', 'dateStart', 'content', 'dateEnd', 'dateLimit'], 'safe'],
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
        $query = Task::find();
        $query->with(['project', 'type', 'author', 'executor']);

        // add conditions that should always apply here
        
        $sort = new Sort(['defaultOrder' => ['id' => SORT_DESC]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'projectId' => $this->projectId,
            'typeId' => $this->typeId,
            'priority' => $this->priority,
            'authorId' => $this->authorId,
            'executorId' => $this->executorId,
            'status' => $this->status,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'dateLimit' => $this->dateLimit,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
