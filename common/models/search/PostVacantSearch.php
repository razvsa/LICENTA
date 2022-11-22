<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PostVacant;

/**
 * PostVacantSearch represents the model behind the search form of `common\models\PostVacant`.
 */
class PostVacantSearch extends PostVacant
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_nom_tip_functie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera'], 'integer'],
            [['pozitie_stat_organizare', 'denumire', 'cerinte', 'oras'], 'safe'],
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
        $query = PostVacant::find();

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
            'id_nom_tip_functie' => $this->id_nom_tip_functie,
            'id_nom_judet' => $this->id_nom_judet,
            'id_nom_nivel_studii' => $this->id_nom_nivel_studii,
            'id_nom_nivel_cariera' => $this->id_nom_nivel_cariera,
        ]);

        $query->andFilterWhere(['like', 'pozitie_stat_organizare', $this->pozitie_stat_organizare])
            ->andFilterWhere(['like', 'denumire', $this->denumire])
            ->andFilterWhere(['like', 'cerinte', $this->cerinte])
            ->andFilterWhere(['like', 'oras', $this->oras]);

        return $dataProvider;
    }
}
