<?php

use common\models\PostFisier;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PostFisier $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Post Fisiers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-fisier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post Fisier', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cale_fisier',
            'data_adaugare',
            'descriere',
            'id',
            'id_post',
            //'id_user_adaugare',
            //'nume_fisier_afisare',
            //'nume_fisier_adaugare',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PostFisier $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
