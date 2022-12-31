<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "key_tip_fisier_dosar_tip_categorie".
 *
 * @property int $id
 * @property int $id_tip_fisier
 * @property int $id_categorie
 */
class KeyTipFisierDosarTipCategorie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_tip_fisier_dosar_tip_categorie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tip_fisier', 'id_categorie'], 'required'],
            [['id_tip_fisier', 'id_categorie'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tip_fisier' => 'Id Tip Fisier',
            'id_categorie' => 'Id Categorie',
        ];
    }
}
