<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%nom_judet}}".
 *
 * @property int $id
 * @property string $nume
 *
 * @property NomLocalitate[] $nomLocalitates
 * @property PostVacant[] $postVacants
 */
class NomJudet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nom_judet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nume'], 'required'],
            [['id'], 'integer'],
            [['nume'], 'string', 'max' => 100],
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
     * Gets query for [[NomLocalitates]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomLocalitateQuery
     */
    public function getNomLocalitates()
    {
        return $this->hasMany(NomLocalitate::class, ['id_nom_judet' => 'id']);
    }

    /**
     * Gets query for [[PostVacants]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostVacantQuery
     */
    public function getPostVacants()
    {
        return $this->hasMany(PostVacant::class, ['id_nom_judet' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NomJudetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NomJudetQuery(get_called_class());
    }
}
