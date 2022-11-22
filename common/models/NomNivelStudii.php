<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%nom_nivel_studii}}".
 *
 * @property int $id
 * @property string $nume
 *
 * @property PostVacant[] $postVacants
 */
class NomNivelStudii extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nom_nivel_studii}}';
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
     * Gets query for [[PostVacants]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostVacantQuery
     */
    public function getPostVacants()
    {
        return $this->hasMany(PostVacant::class, ['id_nom_nivel_studii' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NomNivelStudiiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NomNivelStudiiQuery(get_called_class());
    }
}
