<?php

namespace backend\modules\dorgen\models\search;

use backend\modules\dorgen\models\DorgenSitesSettingsModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DorgenSitesSettingsSearchModel represents the model behind the search form about `backend\modules\glossary\models\DorgenSitesSettingsModel`.
 */
class DorgenSitesSettingsSearchModel extends DorgenSitesSettingsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'safe'],
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
        $query = DorgenSitesSettingsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
