<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "key_candidat_dosar_fisier".
 *
 * @property int $id
 * @property int $id_candidat_dosar
 * @property int $id_candidat_fisier
 */
class KeyCandidatDosarFisier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_candidat_dosar_fisier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_candidat_dosar', 'id_candidat_fisier'], 'required'],
            [['id_candidat_dosar', 'id_candidat_fisier'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_candidat_dosar' => 'Id Candidat Dosar',
            'id_candidat_fisier' => 'Id Candidat Fișier',
        ];
    }
}
