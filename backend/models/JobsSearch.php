<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Jobs;

/**
 * JobsSearch represents the model behind the search form of `common\models\Jobs`.
 */
class JobsSearch extends Jobs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Salariu'], 'integer'],
            [['Denumire', 'Oras', 'Departament', 'Tip', 'Nivel_studii', 'Nivel_cariera'], 'safe'],
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
        $query = Jobs::find();

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
            'id' => $this->id,
            'Salariu' => $this->Salariu,
        ]);

        $query->andFilterWhere(['like', 'Denumire', $this->Denumire])
            ->andFilterWhere(['like', 'Oras', $this->Oras])
            ->andFilterWhere(['like', 'Departament', $this->Departament])
            ->andFilterWhere(['like', 'Tip', $this->Tip])
            ->andFilterWhere(['like', 'Nivel_studii', $this->Nivel_studii])
            ->andFilterWhere(['like', 'Nivel_cariera', $this->Nivel_cariera]);

        return $dataProvider;
    }
}
