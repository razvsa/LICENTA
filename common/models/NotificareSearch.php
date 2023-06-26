<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notificare;

/**
 * NotificareSearch represents the model behind the search form of `common\models\Notificare`.
 */
class NotificareSearch extends Notificare
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stare_notificare'], 'integer'],
            [['continut', 'data_adaugare'], 'safe'],
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
        $query = Notificare::find();

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
            'data_adaugare' => $this->data_adaugare,
            'stare_notificare' => $this->stare_notificare,
        ]);

        $query->andFilterWhere(['like', 'continut', $this->continut]);

        return $dataProvider;
    }
}
