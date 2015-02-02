<?php

namespace backend\modules\dorgen\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dorgen\models\DorgenIndexerRules;

/**
 * DorgenIndexerRulesSearch represents the model behind the search form about `backend\modules\dorgen\models\DorgenIndexerRules`.
 */
class DorgenIndexerRulesSearch extends DorgenIndexerRules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dorgen_site_id'], 'integer'],
            [['attribute', 'function'], 'safe'],
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
        $query = DorgenIndexerRules::find();

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
        ]);

        $query->andFilterWhere(['like', 'attribute', $this->attribute])
            ->andFilterWhere(['like', 'function', $this->function]);

        return $dataProvider;
    }
}
