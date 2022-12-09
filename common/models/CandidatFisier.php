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
 * @property int|null $id_post
 * @property int|null $id_user_adaugare
 * @property string|null $nume_fisier_afisare
 * @property string|null $nume_fisier_adaugare
 * @property int $id_nom_tip_fisier_dosar
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
            [['id_post', 'id_user_adaugare', 'tip'], 'integer'],
            [['tip'], 'required'],
            [['cale_fisier', 'nume_fisier_afisare', 'nume_fisier_adaugare'], 'string', 'max' => 200],
            [['descriere'], 'string', 'max' => 2000],
//            [['fisiere'],'file','extensions'=>'png, pdf, jpeg, jpg','maxSize'=>3*1024*1024,
//                'tooBig'=>'Dimensiunea fisierului este prea mare, max 3MB',
//                'wrongExtension'=>'Extensia fisierului este gresita, se accepta doar png, pdf, jpeg, jpg',
//                'maxFiles'=>10,
//                ],
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
            'id_post' => 'Id Post',
            'id_user_adaugare' => 'Id User Adaugare',
            'nume_fisier_afisare' => 'Nume Fisier Afisare',
            'nume_fisier_adaugare' => 'Nume Fisier Adaugare',
            'id_nom_tip_fisier_dosar' => 'Tip fisier dosar',
        ];
    }
    public function getNomTipFisierDosar()
    {
        return $this->hasOne(NomTipFisierDosar::class, ['id' => 'id_nom_tip_fisier_dosar']);
    }

}
