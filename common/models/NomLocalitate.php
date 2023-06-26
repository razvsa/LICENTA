<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%nom_localitate}}".
 *
 * @property int $id
 * @property int $id_nom_judet
 * @property string $judet
 * @property int $cod_siruta
 * @property string $nume
 *
 * @property NomJudet $nomJudet
 */
class NomLocalitate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nom_localitate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nom_judet', 'judet', 'cod_siruta', 'nume'], 'required'],
            [['id_nom_judet', 'cod_siruta'], 'integer'],
            [['judet'], 'string', 'max' => 50],
            [['nume'], 'string', 'max' => 500],
            [['id_nom_judet'], 'exist', 'skipOnError' => true, 'targetClass' => NomJudet::class, 'targetAttribute' => ['id_nom_judet' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nom_judet' => 'Id Nom Județ',
            'judet' => 'Județ',
            'cod_siruta' => 'Cod Siruta',
            'nume' => 'Nume',
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
     * {@inheritdoc}
     * @return \common\models\query\NomLocalitateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NomLocalitateQuery(get_called_class());
    }
}
