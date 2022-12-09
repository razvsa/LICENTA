<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_tip_categorie".
 *
 * @property int $id
 * @property string $nume
 *
 * @property Anunt[] $anunts
 */
class NomTipCategorie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_tip_categorie';
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
     * Gets query for [[Anunts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnunts()
    {
        return $this->hasMany(Anunt::class, ['categorie_fisier' => 'id']);
    }
}
