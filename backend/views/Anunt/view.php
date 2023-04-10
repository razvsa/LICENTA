<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var \common\models\PostVacant $mod */
/** @var \backend\controllers\AnuntController $posturi */

//$this->title = $model->id;


\yii\web\YiiAsset::register($this);

?>
<div class="anunt-view">

    <h1><?= Html::encode($this->title) ?></h1>


        <!-- Portfolio Item Heading -->
        <h1 class="my-4">Anunt
        </h1>

        <!-- Portfolio Item Row -->
        <div class="row">



            <div class="col-md-12">
                <h3 class="my-3">Detalii anunt:</h3>
                <?php
                    $ddata_concurs=strtotime($model->data_concurs);
                    $ddata_limita_inscriere_concurs=strtotime($model->data_limita_inscriere_concurs);
                    $ddata_depunere_dosar=strtotime($model->data_depunere_dosar);
                    $ddata_postare=strtotime($model->data_postare);
                ?>

                <p style="font-size:17px"><b>Departament:</b> <?=$model->departament?></p>
                <p style="font-size:17px"><b>Data postare:</b> <?=date('d/M/Y h:i',$ddata_postare)?></p>
                <p style="font-size:17px"><b>Data limita inscriere dosar:</b> <?=date('d/M/Y h:i',$ddata_limita_inscriere_concurs)?></p>
                <p style="font-size:17px"><b>Data depunere dosar:</b> <?=date('d/M/Y h:i',$ddata_depunere_dosar)?></p>
                <p style="font-size:17px"><b>Data concurs:</b> <?=date('d/M/Y h:i',$ddata_concurs)?></p>
                <p style="font-size:17px"><b>Descriere: </b> <?=$model->descriere?></p>
            </div>

        </div>
    <br>
    <p>
        <?= Html::a('Actualizeaza anunt', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Sterge anunt', ['sterge-anunt', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= Html::a('Adauga post vacant', ['post-vacant/create','id'=>$model->id], ['class' => 'btn btn-outline-primary']) ?>
    <br>
    <br>
    <h1>Posturile anuntului</h1>
    <br>
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
