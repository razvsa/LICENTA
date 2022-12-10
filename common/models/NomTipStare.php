<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_tip_stare".
 *
 * @property int $id
 * @property string $nume
 *
 * @property CandidatFisier[] $candidatFisiers
 */
class NomTipStare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_tip_stare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nume'], 'required'],
            [['nume'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nume' => 'Nume',
        ];
    }

    /**
     * Gets query for [[CandidatFisiers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatFisiers()
    {
        return $this->hasMany(CandidatFisier::class, ['stare' => 'id']);
    }
}
