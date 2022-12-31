<?php

use common\models\CandidatFisier;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CandidatFisierSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/**@var frontend\controllers\CandidatFisierController $id_user */


?>
<div class="candidat-fisier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php

        $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>$id_user])->asArray()->all();
        if(empty($verificare))
            echo "Nu aveti documente inregistrate";
        else
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'cale_fisier',
                    'data_adaugare',
                    'descriere',
                    //'id',
                    //'id_post',
                    //'id_user_adaugare',
                    //'nume_fisier_afisare',
                    //'nume_fisier_adaugare',
                    //'id_nom_tip_fisier_dosar',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, CandidatFisier $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]);
    ?>



</div>
