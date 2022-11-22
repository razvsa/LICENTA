<?php

use common\models\Anunt;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Anunturi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anunt-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Creeaza Anunt', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_user_adaugare',
            'data_postare',
            'data_concurs',
            'data_depunere_dosar',
            //'id_nom_localitate',
            'departament',
            //'cale_imagine',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Anunt $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
