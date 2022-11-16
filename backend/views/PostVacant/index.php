<?php

use common\models\PostVacant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PostVacantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Post Vacants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-vacant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post Vacant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_nom_tip_functie',
            'pozitie_stat_organizare',
            'denumire',
            'cerinte',
            //'id_nom_judet',
            //'id_nom_nivel_studii',
            //'id_nom_nivel_cariera',
            //'Oras',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PostVacant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
