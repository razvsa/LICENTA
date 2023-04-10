<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_fisier".
 *
 * @property int $id
 * @property string $cale_fisier
 * @property string $data_adaugare
 * @property int $id_user_adaugare
 * @property string $nume_fisier
 * @property int $id_post
 */
class PostFisier extends \yii\db\ActiveRecord
{
    public $fisiere;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_fisier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cale_fisier', 'data_adaugare', 'id_user_adaugare', 'nume_fisier', 'id_post'], 'required'],
            [['data_adaugare'], 'safe'],
            [['id_user_adaugare', 'id_post'], 'integer'],
            [['cale_fisier', 'nume_fisier'], 'string', 'max' => 100],
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
            'cale_fisier' => 'Cale Fisier',
            'data_adaugare' => 'Data Adaugare',
            'id_user_adaugare' => 'Id User Adaugare',
            'nume_fisier' => 'Nume Fisier',
            'id_post' => 'Id Post',
        ];
    }
}
