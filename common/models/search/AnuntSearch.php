<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Anunt;

/**
 * AnuntSearch represents the model behind the search form of `common\models\Anunt`.
 */
class AnuntSearch extends Anunt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user_adaugare','id_nom_localitate'], 'integer'],
            [['data_postare', 'data_concurs', 'data_depunere_dosar', 'departament', 'cale_imagine'], 'safe'],
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
        $query = Anunt::find();

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
            'id_user_adaugare' => $this->id_user_adaugare,
            'data_postare' => $this->data_postare,
            'data_concurs' => $this->data_concurs,
            'data_depunere_dosar' => $this->data_depunere_dosar,
        ]);

        $query->andFilterWhere(['like', 'id_nom_localitate', $this->id_nom_localitate])
            ->andFilterWhere(['like', 'departament', $this->departament])
            ->andFilterWhere(['like', 'cale_imagine', $this->cale_imagine]);

        return $dataProvider;
    }
}
