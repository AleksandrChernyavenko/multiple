<?php

namespace backend\modules\dorgen\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dorgen\models\DorgenCrawlerUrls;

/**
 * DorgenCrawlerUrlsSearch represents the model behind the search form about `backend\modules\dorgen\models\DorgenCrawlerUrls`.
 */
class DorgenCrawlerUrlsSearch extends DorgenCrawlerUrls
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dorgen_site_id', 'is_article'], 'integer'],
            [['url', 'status', 'start_time', 'end_time', 'error_response'], 'safe'],
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
        $query = DorgenCrawlerUrls::find();

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
            'dorgen_site_id' => $this->dorgen_site_id,
            'is_article' => $this->is_article,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'error_response', $this->error_response]);

        return $dataProvider;
    }
}
