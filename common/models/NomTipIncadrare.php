<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_tip_incadrare".
 *
 * @property int $id
 * @property string $nume
 *
 * @property KeyAnuntTipIncadrare[] $keyAnuntTipIncadrares
 */
class NomTipIncadrare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_tip_incadrare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nume'], 'required'],
            [['id'], 'integer'],
            [['nume'], 'string', 'max' => 30],
            [['id'], 'unique'],
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
     * Gets query for [[KeyAnuntTipIncadrares]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntTipIncadrares()
    {
        return $this->hasMany(KeyAnuntTipIncadrare::class, ['id_nom_tip_incadrare' => 'id']);
    }
}
