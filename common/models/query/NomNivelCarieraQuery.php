<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\NomNivelCariera]].
 *
 * @see \common\models\NomNivelCariera
 */
class NomNivelCarieraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\NomNivelCariera[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\NomNivelCariera|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
