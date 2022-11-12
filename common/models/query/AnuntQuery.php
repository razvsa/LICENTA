<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Anunt]].
 *
 * @see \common\models\Anunt
 */
class AnuntQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Anunt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Anunt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
