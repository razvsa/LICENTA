<?php

namespace common\models\query;

use common\models\Jobs;

/**
 * This is the ActiveQuery class for [[\common\models\Jobs]].
 *
 * @see \common\models\Jobs
 */
class JobsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Jobs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Jobs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function latest()
    {
        return $this->orderBy(['created_at'=>SORT_DESC]);
    }
    public function published()
    {
        return $this->andWhere(['status'=>Jobs::STATUS_PUBLISHED]);
    }
}
