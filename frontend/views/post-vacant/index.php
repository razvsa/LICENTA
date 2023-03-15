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
/** @var \frontend\controllers\PostVacantController $titlu */
/** @var \frontend\controllers\PostVacantController $anunt */

$this->title = $titlu;

?>
<div class="post-vacant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <div >
        <?php

       //$diferanta_date=strtotime($anunt->data_concurs)-time();

        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$posturi,
            //'viewParams' => ['diferanta' => $diferanta_date],
            'itemView'=>'_jobs_item',
            'summary' =>''
        ])?>

    </div>


</div>
