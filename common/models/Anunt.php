<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%anunt}}".
 *
 * @property int $id
 * @property int $id_user_adaugare
 * @property string $data_postare
 * @property string $data_concurs
 * @property string $data_depunere_dosar
 * @property string $oras
 * @property string $departament
 *
 * @property AnuntFisier[] $anuntFisiersg
 * @property KeyAnuntPostVacant[] $keyAnuntPostVacants
 * @property KeyAnuntProbaConcurs[] $keyAnuntProbaConcurs
 * @property KeyAnuntTipIncadrare[] $keyAnuntTipIncadrares
 */
class Anunt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%anunt}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user_adaugare', 'data_postare', 'data_concurs', 'data_depunere_dosar', 'oras', 'departament'], 'required'],
            [['id_user_adaugare'], 'integer'],
            [['data_postare', 'data_concurs', 'data_depunere_dosar'], 'safe'],
            [['oras'], 'string', 'max' => 50],
            [['departament'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user_adaugare' => 'Id User Adaugare',
            'data_postare' => 'Data Postare',
            'data_concurs' => 'Data Concurs',
            'data_depunere_dosar' => 'Data Depunere Dosar',
            'oras' => 'Oras',
            'departament' => 'Departament',
        ];
    }

    /**
     * Gets query for [[AnuntFisiers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnuntFisierQuery
     */
    public function getAnuntFisiers()
    {
        return $this->hasMany(AnuntFisier::class, ['id_anunt' => 'id']);
    }

    /**
     * Gets query for [[KeyAnuntPostVacants]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\KeyAnuntPostVacantQuery
     */
    public function getKeyAnuntPostVacants()
    {
        return $this->hasMany(KeyAnuntPostVacant::class, ['id_anunt' => 'id']);
    }

    /**
     * Gets query for [[KeyAnuntProbaConcurs]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\KeyAnuntProbaConcursQuery
     */
    public function getKeyAnuntProbaConcurs()
    {
        return $this->hasMany(KeyAnuntProbaConcurs::class, ['id_anunt' => 'id']);
    }

    /**
     * Gets query for [[KeyAnuntTipIncadrares]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\KeyAnuntTipIncadrareQuery
     */
    public function getKeyAnuntTipIncadrares()
    {
        return $this->hasMany(KeyAnuntTipIncadrare::class, ['id_anunt' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AnuntQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AnuntQuery(get_called_class());
    }
}
