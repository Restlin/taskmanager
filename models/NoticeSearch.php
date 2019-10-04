<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notice;
use yii\data\Sort;

/**
 * NoticeSearch represents the model behind the search form of `app\models\Notice`.
 */
class NoticeSearch extends Notice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'taskId', 'userId', 'actual'], 'integer'],
            [['dateIn', 'event'], 'safe'],
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
        $query = Notice::find();

        // add conditions that should always apply here
        $sort = new Sort(['defaultOrder' => ['id' => SORT_DESC]]);        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort
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
            'taskId' => $this->taskId,
            'userId' => $this->userId,
            'dateIn' => $this->dateIn,
            'actual' => $this->actual,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event]);

        return $dataProvider;
    }
}
