<?php

use common\models\DocumenteUser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\DocumnteUserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Documente Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documente-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Documente User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'CV',
            'diploma_bacalaureat',
            'diploma_licenta',
            'diploma_master',
            //'act_identitate',
            //'carnet_munca',
            //'adeaverinta_vechime_munca',
            //'livret_militar',
            //'certificat_nastere',
            //'certificat_casatorie',
            //'certificat_nastere_partener',
            //'certificat_nastere_copii',
            //'autobiografie',
            //'tabel_nominal_rude',
            //'cazier',
            //'fotografie',
            //'adeverinta_medic_familie',
            //'consintamant_informat',
            //'aviz_psihologic',
            //'declaratie_de_conformitate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DocumenteUser $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
