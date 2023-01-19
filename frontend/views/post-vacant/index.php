<?php

use common\models\PostVacant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PostVacantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \frontend\controllers\AnuntController $posturi  */

$this->title = 'Posturile anuntului';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-vacant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div >
        <?php

        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$posturi,
            'itemView'=>'_jobs_item',
            'summary' =>''
        ])?>

    </div>


</div>
