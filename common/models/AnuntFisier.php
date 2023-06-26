<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anunt_fisier".
 *
 * @property int $id
 * @property int $id_anunt
 * @property string $descriere
 * @property string $nume_fisier_afisare
 * @property string $nume_fisier_salvare
 * @property string $cale_fisier
 * @property string $data_adaugare
 * @property int $id_user_adaugare
 *
 * @property Anunt $anunt
 */
class AnuntFisier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $fisiere;
    public static function tableName()
    {
        return 'anunt_fisier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anunt', 'descriere', 'nume_fisier_afisare', 'nume_fisier_salvare', 'cale_fisier', 'data_adaugare', 'id_user_adaugare'], 'required'],
            [['id_anunt', 'id_user_adaugare'], 'integer'],
            [['data_adaugare'], 'safe'],
            [['descriere'], 'string', 'max' => 1000],
            [['nume_fisier_afisare', 'nume_fisier_salvare', 'cale_fisier'], 'string', 'max' => 500],
            [['id_anunt'], 'exist', 'skipOnError' => true, 'targetClass' => Anunt::class, 'targetAttribute' => ['id_anunt' => 'id']],
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
            'id' => 'ID',
            'id_anunt' => 'Id Anunț',
            'descriere' => 'Descriere',
            'nume_fisier_afisare' => 'Nume Fișier Afișare',
            'nume_fisier_salvare' => 'Nume Fișier Salvare',
            'cale_fisier' => 'Cale Fișier',
            'data_adaugare' => 'Dată Adăugare',
            'id_user_adaugare' => 'Id User Adăugare',
        ];
    }

    /**
     * Gets query for [[Anunt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnunt()
    {
        return $this->hasOne(Anunt::class, ['id' => 'id_anunt']);
    }
}
