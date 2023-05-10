<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "candidat_fisier".
 *
 * @property string|null $cale_fisier
 * @property string|null $data_adaugare
 * @property string|null $descriere
 * @property int $id
 * @property int|null $id_user_adaugare
 * @property string|null $nume_fisier_afisare
 * @property string|null $nume_fisier_adaugare
 * @property int $id_nom_tip_fisier_dosar
 * @property int $stare
 * @property int $id_candidat_dosar
 */
class CandidatFisier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $fisiere;
    public static function tableName()
    {
        return 'candidat_fisier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_adaugare'], 'safe'],
            [[ 'id_user_adaugare', 'id_nom_tip_fisier_dosar'], 'integer'],
            [['id_nom_tip_fisier_dosar'], 'required'],
            [['cale_fisier', 'nume_fisier_afisare', 'nume_fisier_adaugare'], 'string', 'max' => 200],
            [['descriere'], 'string', 'max' => 2000],
            [['fisiere'],'file','extensions'=>'png, pdf, jpeg, jpg','maxSize'=>4*1024*1024,
                'tooBig'=>'Dimensiunea fisierului este prea mare, max 4MB',
                'wrongExtension'=>'Extensia fisierului este gresita, se accepta doar png, pdf, jpeg, jpg',
                'maxFiles'=>10,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cale_fisier' => 'Cale Fisier',
            'data_adaugare' => 'Data Adaugare',
            'descriere' => 'Descriere',
            'id' => 'ID',
            'id_user_adaugare' => 'Id User Adaugare',
            'nume_fisier_afisare' => 'Nume Fisier Afisare',
            'nume_fisier_adaugare' => 'Nume Fisier Adaugare',
            'id_nom_tip_fisier_dosar' => 'Tip fisier dosar',
            'stare'=>'Stare',
        ];
    }
    public function getNomTipFisierDosar()
    {
        return $this->hasOne(NomTipFisierDosar::class, ['id' => 'id_nom_tip_fisier_dosar']);
    }
    public function getNomTipStare()
    {
        return $this->hasOne(NomTipStare::class, ['id' => 'stare']);
    }

    public function respinge(){
        Yii::$app->db->createCommand()->update(CandidatFisier::tableName(),['stare'=>1],['id'=>$this->id])->execute();
    }

    public function aproba(){
        Yii::$app->db->createCommand()->update(CandidatFisier::tableName(),['stare'=>3],['id'=>$this->id])->execute();
    }
    public function getNumeTip(){
        $tip=NomTipFisierDosar::findOne(['id'=>$this->id_nom_tip_fisier_dosar]);
        if($tip) {
            return $tip['nume'];
        }
        else
            return 0;
    }
    public function getNumeTipFaraSpatii(){
        $tip=NomTipFisierDosar::findOne(['id'=>$this->id_nom_tip_fisier_dosar]);
        if($tip) {
            $nume=str_replace(" ","_",$tip['nume']);
            return $nume;
        }
        else
            return 0;
    }




}