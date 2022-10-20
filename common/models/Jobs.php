<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jobs}}".
 *
 * @property int $id
 * @property string|null $Denumire
 * @property string|null $Oras
 * @property string|null $Departament
 * @property string|null $Tip
 * @property string|null $Nivel_studii
 * @property string|null $Nivel_cariera
 * @property int|null $Salariu
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jobs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Salariu'], 'integer'],
            [['Denumire', 'Oras', 'Departament', 'Tip', 'Nivel_studii', 'Nivel_cariera'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Denumire' => 'Denumire',
            'Oras' => 'Oras',
            'Departament' => 'Departament',
            'Tip' => 'Tip',
            'Nivel_studii' => 'Nivel Studii',
            'Nivel_cariera' => 'Nivel Cariera',
            'Salariu' => 'Salariu',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JobsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\JobsQuery(get_called_class());
    }
}
