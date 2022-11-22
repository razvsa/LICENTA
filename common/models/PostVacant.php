<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_vacant}}".
 *
 * @property int $id
 * @property int $id_nom_tip_functie
 * @property string $pozitie_stat_organizare
 * @property string $denumire
 * @property string $cerinte
 * @property int $id_nom_judet
 * @property int $id_nom_nivel_studii
 * @property int $id_nom_nivel_cariera
 * @property string $oras
 *
 * @property NomJudet $nomJudet
 * @property NomNivelCariera $nomNivelCariera
 * @property NomNivelStudii $nomNivelStudii
 */
class PostVacant extends \yii\db\ActiveRecord
{
    public $id_virtual;
    /**
     * {@inheritdoc}
     */
    public $id_anunt;
    public static function tableName()
    {
        return '{{%post_vacant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nom_tip_functie', 'pozitie_stat_organizare', 'denumire', 'cerinte', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera', 'oras'], 'required'],
            [['id_nom_tip_functie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera'], 'integer'],
            [['pozitie_stat_organizare', 'denumire'], 'string', 'max' => 100],
            [['cerinte'], 'string', 'max' => 2000],
            [['oras'], 'string', 'max' => 50],
            [['id_nom_judet'], 'exist', 'skipOnError' => true, 'targetClass' => NomJudet::class, 'targetAttribute' => ['id_nom_judet' => 'id']],
            [['id_nom_nivel_cariera'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelCariera::class, 'targetAttribute' => ['id_nom_nivel_cariera' => 'id']],
            [['id_nom_nivel_studii'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelStudii::class, 'targetAttribute' => ['id_nom_nivel_studii' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nom_tip_functie' => 'Tip Functie',
            'pozitie_stat_organizare' => 'Pozitie Stat Organizare',
            'denumire' => 'Denumire',
            'cerinte' => 'Cerinte',
            'id_nom_judet' => 'Judet',
            'id_nom_nivel_studii' => 'Nivel Studii',
            'id_nom_nivel_cariera' => 'Nivel Cariera',
            'oras' => 'Localitate',
        ];
    }

    /**
     * Gets query for [[NomJudet]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomJudetQuery
     */
    public function getNomJudet()
    {
        return $this->hasOne(NomJudet::class, ['id' => 'id_nom_judet']);
    }

    /**
     * Gets query for [[NomNivelCariera]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomNivelCarieraQuery
     */
    public function getNomNivelCariera()
    {
        return $this->hasOne(NomNivelCariera::class, ['id' => 'id_nom_nivel_cariera']);
    }

    /**
     * Gets query for [[NomNivelStudii]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomNivelStudiiQuery
     */
    public function getNomNivelStudii()
    {
        return $this->hasOne(NomNivelStudii::class, ['id' => 'id_nom_nivel_studii']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostVacantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostVacantQuery(get_called_class());
    }
}
