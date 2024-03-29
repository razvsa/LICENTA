<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizatori';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'username',
        'email:email',
        //'verification_token',
        [
            'attribute' => 'admin',
            'format' => 'raw',
            'filter' => false,
            'value' => function ($model) {
                if ($model->admin == -1) {
                    return Html::a('Transformă în admin', ['/user/admin', 'id' => $model->id], ['class' => 'btn btn-outline-info']);
                } else if ($model->admin > 0) {
                    return \common\models\NomStructura::findOne(['id' => $model->admin])['nume'];
                }
                return "Administrator";
            },
        ],
        //'status',
        //'created_at',
        //'updated_at',
        [
            'class' => ActionColumn::className(),
            'template' => '{view}', // Eliminați 'delete' și 'update' din șablonul de butoane
            'urlCreator' => function ($action, $model, $key, $index) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
    ]); ?>


</div>
