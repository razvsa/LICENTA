<?php
/** @var $model \common\models\Video */
/** @var yii\web\View $this */





    /*GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'Denumire',
        'Oras',
        'Departament',
        'Tip',
        //'Nivel_studii',
        //'Nivel_cariera',
        //'Salariu',
        [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, Jobs $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
]);*/

?>
<div class="row">
    <div class="col-sm-8">
        <div class="col-sm-3">
            <h2 class="card-title"><?php echo $model->Denumire?></h2>
            <img class="card-img" src="@web/frontend/web/storage/image34.png">
        </div>
        <div class="card-body col-sm-6">
            <p class="card-text"><?php echo $model->Oras?></p>
            <button class="btn btn-primary">Aplica</button>
        </div>
    </div>
    <div class="col-sm-4">

    </div>
</div>
