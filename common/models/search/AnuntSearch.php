<?php

namespace common\models\search;

use common\models\KeyAnuntPostVacant;
use common\models\NomLocalitate;
use common\models\PostVacant;
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
//        echo '<pre>';
//        print_r($params);
//        echo '</pre>';
//        die();
        if(empty($params))
             $query = Anunt::find();
        else {
            $query = Anunt::find()
                ->innerJoin(['kapv' => KeyAnuntPostVacant::tableName()], 'kapv.id_anunt=anunt.id')
                ->innerJoin(['post' => PostVacant::tableName()], 'post.id=kapv.id_post_vacant');
            if ($params['AnuntSearch']['id_nom_tip_functie'] != "")
                $query->andWhere(['post.id_nom_tip_functie' => $params['AnuntSearch']['id_nom_tip_functie']]);
            if ($params['AnuntSearch']['id_nom_nivel_studii'] != "")
                $query->andWhere(['post.id_nom_nivel_studii' => $params['AnuntSearch']['id_nom_nivel_studii']]);

            if ($params['AnuntSearch']['id_nom_judet'] != "") {
                if ($params['AnuntSearch']['oras'] == "")
                    $query->andWhere(['post.id_nom_judet' => $params['AnuntSearch']['id_nom_judet']]);
                else if ($params['AnuntSearch']['oras'] != "")
                    $query->andWhere(['post.oras' => $params['AnuntSearch']['oras']]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

}
