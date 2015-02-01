<?php

namespace backend\modules\xss\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\xss\models\XssCookie;

/**
 * XssCookieSearch represents the model behind the search form about `backend\modules\xss\models\XssCookie`.
 */
class XssCookieSearch extends XssCookie
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sites_id', 'is_mobile'], 'integer'],
            [['created_at', 'from_url', 'from_ip', 'user_agent', 'cookie'], 'safe'],
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
        $query = XssCookie::find();

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
            'sites_id' => $this->sites_id,
            'created_at' => $this->created_at,
            'is_mobile' => $this->is_mobile,
        ]);

        $query->andFilterWhere(['like', 'from_url', $this->from_url])
            ->andFilterWhere(['like', 'from_ip', $this->from_ip])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'cookie', $this->cookie]);

        return $dataProvider;
    }
}
