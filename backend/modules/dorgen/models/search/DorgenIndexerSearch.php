<?php

namespace backend\modules\dorgen\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dorgen\models\DorgenIndexer;

/**
 * DorgenIndexerSearch represents the model behind the search form about `backend\modules\dorgen\models\DorgenIndexer`.
 */
class DorgenIndexerSearch extends DorgenIndexer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dorgen_spider_translate_id'], 'integer'],
            [['status', 'start_time', 'end_time', 'error_response'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = DorgenIndexer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'dorgen_spider_translate_id' => $this->dorgen_spider_translate_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'error_response', $this->error_response]);

        return $dataProvider;
    }
}
