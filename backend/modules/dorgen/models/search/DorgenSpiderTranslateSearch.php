<?php

namespace backend\modules\dorgen\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dorgen\models\DorgenSpiderTranslate;

/**
 * DorgenSpiderTranslateSearch represents the model behind the search form about `backend\modules\dorgen\models\DorgenSpiderTranslate`.
 */
class DorgenSpiderTranslateSearch extends DorgenSpiderTranslate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dorgen_crawler_url_id'], 'integer'],
            [['status', 'date_start', 'date_end', 'file_name', 'error_response'], 'safe'],
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
        $query = DorgenSpiderTranslate::find();

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
            'dorgen_crawler_url_id' => $this->dorgen_crawler_url_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'error_response', $this->error_response]);

        return $dataProvider;
    }
}
