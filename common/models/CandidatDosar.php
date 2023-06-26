<?php

namespace common\models;

use Yii;
use function GuzzleHttp\Psr7\str;

/**
 * This is the model class for table "candidat_dosar".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_post_vacant
 * @property int $id_status
 */
class CandidatDosar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidat_dosar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_post_vacant', 'id_status'], 'required'],
            [['id_user', 'id_post_vacant', 'id_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_post_vacant' => 'Id Post Vacant',
            'id_status' => 'Id Status',
        ];
    }
    public function getNumePost(){
        $post=PostVacant::findOne(['id'=>$this->id_post_vacant]);
        if($post!=null)
            return $post->denumire;
        else
            return 0;
    }

    public function getNumeUser(){
        $user=User::findOne(['id'=>$this->id_user]);
        if($user!=null)
            return $user->username;
        else return 0;
    }


    public function getStatus(){
        $status=NomStatus::findOne(['id'=>$this->id_status]);
        if($status==null)
            return 0;
        else
            return $status->nume;
    }
    public function getDocumenteLipsa(){

        $dosar=CandidatDosar::findOne(['id'=>$this->id]);
        $fisiere_necesare = NomTipFisierDosar::find()
            ->innerJoin(['k' => KeyTipFisierDosarTipCategorie::tableName()], 'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a' => Anunt::tableName()], 'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['p' => PostVacant::tableName()], 'p.id_anunt=a.id')
            ->where(['p.id' => $dosar['id_post_vacant']])
            ->asArray()->all();
        $fisiere_existente_dosar=NomTipFisierDosar::find()
            ->innerJoin(['c'=>CandidatFisier::tableName()],'nom_tip_fisier_dosar.id=c.id_nom_tip_fisier_dosar')
            ->where(['c.id_candidat_dosar'=>$this->id])->asArray()->all();
        $fisiere_lipsa=array();

        $var = 0;
        for ($i = 0; $i < count($fisiere_necesare); $i++) {
            for ($j = 0; $j < count($fisiere_existente_dosar); $j++) {
                if ($fisiere_necesare[$i]['id'] == $fisiere_existente_dosar[$j]['id'] && $fisiere_necesare[$i]['nume'] == $fisiere_existente_dosar[$j]['nume'])
                    $var = 1;
            }
            if ($var == 0) {
                array_push($fisiere_lipsa, $fisiere_necesare[$i]);
            }
            $var = 0;
        }
        if(empty($fisiere_lipsa)==1)
            return "";
        else
            return $fisiere_lipsa;

    }
    public function getListaDocumenteLipsa(){
        $documente_lipsa=$this->getDocumenteLipsa();
        $string="Documentele lipsa ale dosarului sunt: ";
        foreach ($documente_lipsa as $d){
            $string=$string.$d['nume'].', ';
        }
        return $string;
    }
}
