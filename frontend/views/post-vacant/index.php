<?php

use common\models\PostVacant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PostVacantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \frontend\controllers\PostVacantController $posturi  */
/** @var \frontend\controllers\PostVacantController $titlu */
/** @var \frontend\controllers\PostVacantController $anunt */
/** @var \frontend\controllers\PostVacantController $posturilemele */

$this->title = $titlu;

?>
<div class="post-vacant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <div >
        <?php
        if($posturilemele==1 && Yii::$app->user->isGuest)
        {
            echo '<p class="alert alert-danger" role="alert">Nu aveti acces la aceasta pagina</p>';
        }
        //$diferanta_date=strtotime($anunt->data_concurs)-time();
        else
            echo \yii\widgets\ListView::widget([

                'dataProvider'=>$posturi,
                //'viewParams' => ['diferanta' => $diferanta_date],
                'itemView'=>'_jobs_item',
                'summary' =>''
            ])?>

    </div>


</div>
