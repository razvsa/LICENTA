<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%nom_departament}}".
 *
 * @property int $id
 * @property string $nume
 */
class NomDepartament extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nom_departament}}';
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
            'nume' => 'Nume',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NomDepartamentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NomDepartamentQuery(get_called_class());
    }
}
