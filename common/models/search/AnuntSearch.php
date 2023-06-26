<?php

namespace common\models\search;

use common\models\NomJudet;
use common\models\NomLocalitate;
use common\models\NomNivelCariera;
use common\models\NomNivelStudii;
use common\models\NomTipIncadrare;
use common\models\PostVacant;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Anunt;
use yii\elasticsearch\Connection;
use yii\elasticsearch\Query;
use function React\Promise\all;

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
            [['id', 'id_user_adaugare'], 'integer'],
            [['data_postare', 'data_concurs', 'data_depunere_dosar', 'departament', 'titlu'], 'safe'],
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
    public function search_admin($params)
    {

        if(empty($params['AnuntSearch']['id_nom_tip_functie']) &&
            empty($params['AnuntSearch']['id_nom_nivel_studii']) &&
            empty($params['AnuntSearch']['id_nom_nivel_cariera']) &&
            empty($params['AnuntSearch']['postare']) &&
            empty($params['AnuntSearch']['id_nom_judet'])) {

            if(\Yii::$app->user->getIdentity()->admin==0) {
                $query = Anunt::find();
            }

            else
                $query=Anunt::find()
                    ->where(['id_structura'=>\Yii::$app->user->getIdentity()->admin]);
        }
//        else {
//            $lista_id_posturi=-1;
//            if(!empty($params)) {
//                if ($params['AnuntSearch']['cuvant'] != "") {
//
//                    $connection = new Connection();
////                    $id_anunturi = array_column($query->asArray()->all(), 'id');
////                $posturi = PostVacant::find()
////                    ->select(['post_vacant.id', 'fct.nume AS tip_functie', 'post_vacant.denumire', 'post_vacant.cerinte','post_vacant.bibliografie','post_vacant.tematica', 'judet.nume AS judet', 'studii.nume AS nivel_studii', 'cariera.nume AS nivel_cariera', 'oras.nume AS oras'])
////                    ->innerJoin(['anunt' => Anunt::tableName()], 'anunt.id=post_vacant.id_anunt')
////                    ->innerJoin(['fct' => NomTipIncadrare::tableName()], 'fct.id=post_vacant.id_nom_tip_functie')
////                    ->innerJoin(['judet' => NomJudet::tableName()], 'judet.id=post_vacant.id_nom_judet')
////                    ->innerJoin(['studii' => NomNivelStudii::tableName()], 'studii.id=post_vacant.id_nom_nivel_studii')
////                    ->innerJoin(['cariera' => NomNivelCariera::tableName()], 'cariera.id=post_vacant.id_nom_nivel_cariera')
////                    ->innerJoin(['oras' => NomLocalitate::tableName()], 'oras.id=post_vacant.oras')
////                    ->asArray()->all();
////                                        foreach($posturi as $post)
////                        $command->insert('post', '_doc', $post);
//
//
//                    $query_elastic = new Query();
//                    $command = $connection->createCommand();
//
//
//                    $query_elastic->from('post_final')
//                        ->query([
//                            'multi_match' => [
//                                'query' =>$params['AnuntSearch']['cuvant'] ,
//                                'fields' => ['*'],
//                                'fuzziness' => 2,
//                                'prefix_length' => 2,
//                            ]
//                        ]);
//                    $results = $query_elastic->all();
//                    $rezultate = array_column($results, '_source');
//                    $lista_id_posturi = array_column($rezultate,'id');
//
//
//
//                }
//            }
            else{

            if(\Yii::$app->user->getIdentity()->admin==0)
                $query = Anunt::find()
                    ->innerJoin(['post' => PostVacant::tableName()], 'anunt.id=post.id_anunt');
            else
                $query = Anunt::find()
                    ->innerJoin(['post' => PostVacant::tableName()], 'anunt.id=post.id_anunt')
                    ->where(['id_structura'=>\Yii::$app->user->getIdentity()->admin]);
            if ($params['AnuntSearch']['postare'] != "")
                $query->Where(['anunt.postat' => $params['AnuntSearch']['postare']-1]);
            //if($lista_id_posturi!=-1)
             //   $query->andWhere(['post.id' => $lista_id_posturi]);
            if ($params['AnuntSearch']['id_nom_tip_functie'] != "")
                $query->andWhere(['post.id_nom_tip_functie' => $params['AnuntSearch']['id_nom_tip_functie']]);

            if ($params['AnuntSearch']['id_nom_nivel_studii'] != "")
                $query->andWhere(['post.id_nom_nivel_studii' => $params['AnuntSearch']['id_nom_nivel_studii']]);
            if ($params['AnuntSearch']['id_nom_nivel_cariera'] != "")
                $query->andWhere(['post.id_nom_nivel_cariera' => $params['AnuntSearch']['id_nom_nivel_cariera']]);
            if ($params['AnuntSearch']['id_nom_judet'] != "") {
                if ($params['AnuntSearch']['oras'] == "")
                    $query->andWhere(['post.id_nom_judet' => $params['AnuntSearch']['id_nom_judet']]);
                else
                    $query->andWhere(['post.oras' => $params['AnuntSearch']['oras']]);
            }

        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_postare'=> SORT_DESC]),
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
    public function search_user($params){

        if(empty($params['AnuntSearch']['cuvant']) &&
            empty($params['AnuntSearch']['id_nom_tip_functie']) &&
            empty($params['AnuntSearch']['id_nom_nivel_studii']) &&
            empty($params['AnuntSearch']['id_nom_nivel_cariera']) &&
            empty($params['AnuntSearch']['id_nom_judet'])) {
            $query = Anunt::find()->where(['postat'=>1]);
        }
        else {
            $lista_id_posturi=-1;

            if(!empty($params)) {
                if ($params['AnuntSearch']['cuvant'] != "") {

                    $connection = new Connection();
                    $command = $connection->createCommand();
//                    $id_anunturi = array_column($query->asArray()->all(), 'id');
//                $posturi = PostVacant::find()
//                    ->select(['post_vacant.id', 'fct.nume AS tip_functie', 'post_vacant.denumire', 'post_vacant.cerinte','post_vacant.bibliografie','post_vacant.tematica', 'judet.nume AS judet', 'studii.nume AS nivel_studii', 'cariera.nume AS nivel_cariera', 'oras.nume AS oras'])
//                    ->innerJoin(['anunt' => Anunt::tableName()], 'anunt.id=post_vacant.id_anunt')
//                    ->innerJoin(['fct' => NomTipIncadrare::tableName()], 'fct.id=post_vacant.id_nom_tip_functie')
//                    ->innerJoin(['judet' => NomJudet::tableName()], 'judet.id=post_vacant.id_nom_judet')
//                    ->innerJoin(['studii' => NomNivelStudii::tableName()], 'studii.id=post_vacant.id_nom_nivel_studii')
//                    ->innerJoin(['cariera' => NomNivelCariera::tableName()], 'cariera.id=post_vacant.id_nom_nivel_cariera')
//                    ->innerJoin(['oras' => NomLocalitate::tableName()], 'oras.id=post_vacant.oras')
//                    ->asArray()->all();
//
//                    foreach($posturi as $post)
//                        $command->insert('post_final', '_doc', $post);


                    $query_elastic = new Query();

//                    $r=$query_elastic->from('post_final')->query([
//                    ])->count();
//                    echo '<pre>';
//                    print_r($r);
//                    die;
//                    echo '</pre>';


                    $query_elastic->from('post_final')
                        ->query([
                            'multi_match' => [
                                'query' =>$params['AnuntSearch']['cuvant'] ,
                                'fields' => ['*'],
                                'fuzziness' => 2,
                                'prefix_length' => 2,
                            ]
                        ]);
                    $results = $query_elastic->all();
                    $rezultate = array_column($results, '_source');
                    $lista_id_posturi = array_column($rezultate,'id');

                    $query = Anunt::find()
                        ->innerJoin(['post' => PostVacant::tableName()], 'post.id_anunt=anunt.id')
                        ->where(['post.id' => $lista_id_posturi]);


                }
            }

            $query = Anunt::find()
                ->innerJoin(['post' => PostVacant::tableName()], 'post.id_anunt=anunt.id')
                ->where(['postat'=>1]);


            if($lista_id_posturi!=-1)
                $query->Where(['post.id' => $lista_id_posturi]);
            if ($params['AnuntSearch']['id_nom_tip_functie'] != "")
                $query->andWhere(['post.id_nom_tip_functie' => $params['AnuntSearch']['id_nom_tip_functie']]);
            if ($params['AnuntSearch']['id_nom_nivel_studii'] != "")
                $query->andWhere(['post.id_nom_nivel_studii' => $params['AnuntSearch']['id_nom_nivel_studii']]);
            if ($params['AnuntSearch']['id_nom_nivel_cariera'] != "")
                $query->andWhere(['post.id_nom_nivel_cariera' => $params['AnuntSearch']['id_nom_nivel_cariera']]);
            if ($params['AnuntSearch']['id_nom_judet'] != "") {
                if ($params['AnuntSearch']['oras'] == "")
                    $query->andWhere(['post.id_nom_judet' => $params['AnuntSearch']['id_nom_judet']]);
                else
                    $query->andWhere(['post.oras' => $params['AnuntSearch']['oras']]);
            }

        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['data_postare'=> SORT_DESC]),
            'pagination' => [
                'pageSize' => 40,
            ],
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
