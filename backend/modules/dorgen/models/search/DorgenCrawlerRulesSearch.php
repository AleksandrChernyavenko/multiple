<?php

namespace backend\modules\dorgen\models\search;

use backend\modules\dorgen\models\DorgenCrawlerRules;
use backend\modules\dorgen\models\DorgenSites;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DorgenCrawlerRulesSearch represents the model behind the search form about `backend\modules\dorgen\models\DorgenCrawlerRules`.
 */
class DorgenCrawlerRulesSearch extends DorgenCrawlerRules
{

    public $site;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'required'], 'integer'],
            [['name', 'type', 'value'], 'safe'],
            [['site'], 'safe'],
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
        $query = DorgenCrawlerRules::find();

        $query->joinWith(['site']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes['site'] = [
            'asc'=>[DorgenSites::tableName().'.id'=> SORT_ASC],
            'desc'=>[DorgenSites::tableName().'.id'=> SORT_DESC],
        ];

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            self::tableName().'.required' => $this->required,
        ]);

        $query->andFilterWhere(['like',  self::tableName().'.name', $this->name])
            ->andFilterWhere(['like',  self::tableName().'.type', $this->type])
            ->andFilterWhere(['like',  self::tableName().'.value', $this->value]);

        $query->andFilterWhere([
            'AND',
            [
                'OR',
                ['=', DorgenSites::tableName().'.id', $this->site],
                ['like', DorgenSites::tableName().'.name', $this->site]
            ]
        ]);



//        VarDumper::dump($query,3,3);exit;

        return $dataProvider;
    }
}
