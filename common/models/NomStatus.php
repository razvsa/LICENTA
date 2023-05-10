<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_status".
 *
 * @property int $id
 * @property string $nume
 */
class NomStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_status';
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
}
