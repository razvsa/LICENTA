<?php

use common\models\PostVacant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PostVacantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \backend\controllers\PostVacantController $posturi */

$this->title = 'Posturi Anuntului';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-vacant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div >
        <?php
        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$posturi,
            'itemView'=>'_post_item',
            'summary' =>''
        ])?>

    </div>
    <br>
    <?= Html::a('< Inapoi la Anunturi',['anunt/index'],['class'=>'btn btn-outline-primary'])?>
</div>
