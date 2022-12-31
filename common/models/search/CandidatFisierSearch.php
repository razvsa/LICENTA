<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CandidatFisier;
use Yii;

/**
 * CandidatFisierSearch represents the model behind the search form of `common\models\CandidatFisier`.
 */
class CandidatFisierSearch extends CandidatFisier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cale_fisier', 'data_adaugare', 'descriere', 'nume_fisier_afisare', 'nume_fisier_adaugare'], 'safe'],
            [['id', 'id_user_adaugare', 'id_nom_tip_fisier_dosar'], 'integer'],
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
        $query = CandidatFisier::find()->where(['id_user_adaugare'=>Yii::$app->user->identity->id]);;

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
            'data_adaugare' => $this->data_adaugare,
            'id' => $this->id,
            'id_user_adaugare' => $this->id_user_adaugare,
            'id_nom_tip_fisier_dosar' => $this->id_nom_tip_fisier_dosar,
        ]);

        $query->andFilterWhere(['like', 'cale_fisier', $this->cale_fisier])
            ->andFilterWhere(['like', 'descriere', $this->descriere])
            ->andFilterWhere(['like', 'nume_fisier_afisare', $this->nume_fisier_afisare])
            ->andFilterWhere(['like', 'nume_fisier_adaugare', $this->nume_fisier_adaugare]);

        return $dataProvider;
    }
}
