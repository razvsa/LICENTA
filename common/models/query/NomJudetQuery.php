<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\NomJudet]].
 *
 * @see \common\models\NomJudet
 */
class NomJudetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\NomJudet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\NomJudet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
