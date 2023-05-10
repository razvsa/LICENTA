<?php

use common\models\CandidatDosar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dosarele mele';

//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidat-dosar-index">

    <h2><?= Html::encode($this->title) ?></h2><hr style="border-top: 1px solid black;">
    <div >
        <br>
        <?php
        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$dataProvider,
            'itemView'=>'_dosar_item',
            'viewParams' => ['status' => 2],
            'summary' =>''
        ])?>
    </div>
</div>
