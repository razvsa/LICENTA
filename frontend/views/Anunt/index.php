<?php

use common\models\Anunt;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \frontend\controllers\AnuntController $localitati */
/** @var \frontend\controllers\AnuntController $departamente */

$this->title = 'Anunturi';

?>
<div class="anunt-index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <!-- Sidebar -->
    <div class="w3-sidebar" >
        <h3 class="w3-bar-item">Filtreaza</h3>
        <?php //echo $this->render('_search', ['model' => $searchModel,'localitati'=>$localitati,'departamente'=>$departamente]); ?>
    </div>

    <!-- Page Content -->
    <div style="margin-left:25%">
        <?php
        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$dataProvider,
            'itemView'=>'_jobs_item',
            'summary' =>''
        ])?>

    </div>

</div>