<?php

use common\models\Anunt;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Anunts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anunt-index">



    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$dataProvider,
        'itemView'=>'_jobs_item',
        'summary' =>''
    ])?>


</div>
