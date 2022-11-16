<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_vacant".
 *
 * @property int $id
 * @property int $id_nom_tip_functie
 * @property string $pozitie_stat_organizare
 * @property string $denumire
 * @property string $cerinte
 * @property int $id_nom_judet
 * @property int $id_nom_nivel_studii
 * @property int $id_nom_nivel_cariera
 * @property string $Oras
 *
 * @property KeyAnuntPostVacant[] $keyAnuntPostVacants
 * @property NomJudet $nomJudet
 * @property NomNivelCariera $nomNivelCariera
 * @property NomNivelStudii $nomNivelStudii
 */
class PostVacant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_vacant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_nom_tip_functie', 'pozitie_stat_organizare', 'denumire', 'cerinte', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera', 'Oras'], 'required'],
            [['id', 'id_nom_tip_functie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera'], 'integer'],
            [['pozitie_stat_organizare', 'denumire', 'Oras'], 'string', 'max' => 100],
            [['cerinte'], 'string', 'max' => 1000],
            [['id'], 'unique'],
            [['id_nom_judet'], 'exist', 'skipOnError' => true, 'targetClass' => NomJudet::class, 'targetAttribute' => ['id_nom_judet' => 'id']],
            [['id_nom_nivel_studii'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelStudii::class, 'targetAttribute' => ['id_nom_nivel_studii' => 'id']],
            [['id_nom_nivel_cariera'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelCariera::class, 'targetAttribute' => ['id_nom_nivel_cariera' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nom_tip_functie' => 'Id Nom Tip Functie',
            'pozitie_stat_organizare' => 'Pozitie Stat Organizare',
            'denumire' => 'Denumire',
            'cerinte' => 'Cerinte',
            'id_nom_judet' => 'Id Nom Judet',
            'id_nom_nivel_studii' => 'Id Nom Nivel Studii',
            'id_nom_nivel_cariera' => 'Id Nom Nivel Cariera',
            'Oras' => 'Oras',
        ];
    }

    /**
     * Gets query for [[KeyAnuntPostVacants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntPostVacants()
    {
        return $this->hasMany(KeyAnuntPostVacant::class, ['id_post_vacant' => 'id']);
    }

    /**
     * Gets query for [[NomJudet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomJudet()
    {
        return $this->hasOne(NomJudet::class, ['id' => 'id_nom_judet']);
    }

    /**
     * Gets query for [[NomNivelCariera]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomNivelCariera()
    {
        return $this->hasOne(NomNivelCariera::class, ['id' => 'id_nom_nivel_cariera']);
    }

    /**
     * Gets query for [[NomNivelStudii]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomNivelStudii()
    {
        return $this->hasOne(NomNivelStudii::class, ['id' => 'id_nom_nivel_studii']);
    }
}
