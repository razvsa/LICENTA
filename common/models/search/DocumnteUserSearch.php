<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DocumenteUser;

/**
 * DocumnteUserSearch represents the model behind the search form of `common\models\DocumenteUser`.
 */
class DocumnteUserSearch extends DocumenteUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'CV', 'diploma_bacalaureat', 'diploma_licenta', 'diploma_master', 'act_identitate', 'carnet_munca', 'adeaverinta_vechime_munca', 'livret_militar', 'certificat_nastere', 'certificat_casatorie', 'certificat_nastere_partener', 'certificat_nastere_copii', 'autobiografie', 'tabel_nominal_rude', 'cazier', 'fotografie', 'adeverinta_medic_familie', 'consintamant_informat', 'aviz_psihologic', 'declaratie_de_conformitate'], 'integer'],
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
        $query = DocumenteUser::find();

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
            'CV' => $this->CV,
            'diploma_bacalaureat' => $this->diploma_bacalaureat,
            'diploma_licenta' => $this->diploma_licenta,
            'diploma_master' => $this->diploma_master,
            'act_identitate' => $this->act_identitate,
            'carnet_munca' => $this->carnet_munca,
            'adeaverinta_vechime_munca' => $this->adeaverinta_vechime_munca,
            'livret_militar' => $this->livret_militar,
            'certificat_nastere' => $this->certificat_nastere,
            'certificat_casatorie' => $this->certificat_casatorie,
            'certificat_nastere_partener' => $this->certificat_nastere_partener,
            'certificat_nastere_copii' => $this->certificat_nastere_copii,
            'autobiografie' => $this->autobiografie,
            'tabel_nominal_rude' => $this->tabel_nominal_rude,
            'cazier' => $this->cazier,
            'fotografie' => $this->fotografie,
            'adeverinta_medic_familie' => $this->adeverinta_medic_familie,
            'consintamant_informat' => $this->consintamant_informat,
            'aviz_psihologic' => $this->aviz_psihologic,
            'declaratie_de_conformitate' => $this->declaratie_de_conformitate,
        ]);

        return $dataProvider;
    }
}
