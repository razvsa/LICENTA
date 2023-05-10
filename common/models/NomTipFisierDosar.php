<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_tip_fisier_dosar".
 *
 * @property int $id
 * @property string $nume
 * @property int $id_structura
 *
 * @property CandidatFisier[] $candidatFisiers
 * @property KeyTipFisierDosarTipCategorie[] $keyTipFisierDosarTipCategories
 */
class NomTipFisierDosar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_tip_fisier_dosar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nume'], 'required'],
            [['id_structura'], 'integer'],
            [['nume'], 'string', 'max' => 200],
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
            'id_structura' => 'Id Structura',
        ];
    }

    /**
     * Gets query for [[CandidatFisiers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCandidatFisiers()
    {
        return $this->hasMany(CandidatFisier::class, ['id_nom_tip_fisier_dosar' => 'id']);
    }

    /**
     * Gets query for [[KeyTipFisierDosarTipCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyTipFisierDosarTipCategories()
    {
        return $this->hasMany(KeyTipFisierDosarTipCategorie::class, ['id_tip_fisier' => 'id']);
    }
    public function getNumeStructura(){
        if($this->id_structura==0)
            return 0;
        else{
            $structura=NomStructura::findOne(['id'=>$this->id_structura]);
            if($structura!==null)
                return $structura->nume;
            else
                return 0;

        }
    }
}
