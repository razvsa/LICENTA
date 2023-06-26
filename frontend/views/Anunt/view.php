<?php

use common\models\PostVacant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\base\View;


/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var common\models\search\PostVacantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \frontend\controllers\AnuntController $posturi  */
/** @var \frontend\controllers\AnuntController  $titlu */
/** @var \frontend\controllers\AnuntController  $model */
/** @var \frontend\controllers\AnuntController  $posturilemele */
/** @var \frontend\controllers\AnuntController  $fisiere */
/** @var \frontend\controllers\AnuntController  $nr_posturi */


$this->title = 'Anunt';
?>
<div>
    <div >
        <?php
//        if($posturilemele==1 && Yii::$app->user->isGuest)
//        {
//            echo '<p class="alert alert-danger" role="alert">Nu aveti acces la aceasta pagina</p>';
//        }
//        else{?>
        <h2 ><?=$model->titlu?></h2>
        <hr style='border-top: 1px solid black;'>
        <br>
        <div class="row">



            <div class="col-md-12">
                <?php
                $ddata_concurs=strtotime($model->data_concurs);
                $ddata_limita_inscriere_concurs=strtotime($model->data_limita_inscriere_concurs);
                $ddata_depunere_dosar=strtotime($model->data_depunere_dosar);
                $ddata_postare=strtotime($model->data_postare);
                ?>

                <p style="font-size:17px"><b>Structură:</b> <?=$model->getNumeStructura()?></p>
                <p style="font-size:17px"><b>Postat la:</b> <?=date('d/M/Y h:i',$ddata_postare)?></p>
                <p style="font-size:17px"><b>Descriere: </b> <?=$model->descriere?></p>
                <p style="font-size:17px"><b>Dată limită înscriere dosar:</b> <?=date('d/M/Y h:i',$ddata_limita_inscriere_concurs)?></p>
                <p style="font-size:17px"><b>Dată depunere dosar:</b> <?=date('d/M/Y h:i',$ddata_depunere_dosar)?></p>
                <p style="font-size:17px"><b>Dată concurs:</b> <?=date('d/M/Y h:i',$ddata_concurs)?></p>

            </div>

        </div>
        <br>
        <br>
        <h4>Fișierele anunțului:</h4>
        <hr style='border-top: 1px solid black;'>
        <br>
        <?php

        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$fisiere,
            'itemView'=>'_fisier_item',
            'emptyText' => 'Nu există fisiere încarcate',
            'viewParams'=>['id_anunt'=>$model->id],
            'summary' =>''
        ]);?>
        <br>
        <br>
            <?php
            if($nr_posturi>=2)
                echo \yii\widgets\ListView::widget([

                    'dataProvider'=>$posturi,
                    'emptyText' => 'Acest anunț nu are posturi asociate.',
                    'itemView'=>'_post_item',
                    'summary' =>''
                ]);
            else if($nr_posturi==1){
                echo "<br><br><h2>Post Vacant:</h2><hr style='border-top: 2px solid black;'><br>";
                echo $this->renderFile(Yii::getAlias('@frontend').'\views\post-vacant\view.php',[
                    'model' => PostVacant::find()->where(['id_anunt'=>$model->id])->one(),
                    'id_anunt'=>$model->id,
                ]);
            }
            else
                echo "Nu există posturi în cadrul acestui anunț";
            ?>

    </div>


</div>
