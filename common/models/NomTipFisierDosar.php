<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_tip_fisier_dosar".
 *
 * @property int $id
 * @property string $nume
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
            'nume' => '',
        ];
    }
}
