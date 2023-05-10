<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */
/** @var \common\models\PostVacant $mod */
/** @var \backend\controllers\AnuntController $posturi */
/** @var \backend\controllers\AnuntController $fisiere */
/** @var \backend\controllers\AnuntController $id_anunt */
/** @var \backend\controllers\AnuntController $nr_posturi */
/** @var \backend\controllers\AnuntController $document */

//$this->title = $model->id;


\yii\web\YiiAsset::register($this);

?>
<div class="anunt-view">

    <h1><?= Html::encode($this->title) ?></h1>


        <!-- Portfolio Item Heading -->
        <h1 class="my-4"><?=$model->titlu?>
        </h1>

        <!-- Portfolio Item Row -->
        <div class="row">



            <div class="col-md-12">
                <?php
                    $ddata_concurs=strtotime($model->data_concurs);
                    $ddata_limita_inscriere_concurs=strtotime($model->data_limita_inscriere_concurs);
                    $ddata_depunere_dosar=strtotime($model->data_depunere_dosar);
                    $ddata_postare=strtotime($model->data_postare);
                ?>

                <p style="font-size:17px"><b>Structura:</b> <?=$model->getNumeStructura()?></p>
                <p style="font-size:17px"><b>Postat la:</b> <?=date('d/M/Y h:i',$ddata_postare)?></p>
                <p style="font-size:17px"><b>Descriere: </b> <?=$model->descriere?></p>
                <p style="font-size:17px"><b>Data limita inscriere dosar:</b> <?=date('d/M/Y h:i',$ddata_limita_inscriere_concurs)?></p>
                <p style="font-size:17px"><b>Data depunere dosar:</b> <?=date('d/M/Y h:i',$ddata_depunere_dosar)?></p>
                <p style="font-size:17px"><b>Data concurs:</b> <?=date('d/M/Y h:i',$ddata_concurs)?></p>

            </div>

        </div>
    <br>
      <?php
        if($model->estePostat()==0) {
            echo '<p>';
            echo Html::a('Actualizeaza anunt', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']);
            echo Html::a('Sterge anunt', ['sterge-anunt', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
            echo Html::a('Posteaza anunt', ['posteaza-anunt', 'id' => $model->id], [
                'class' => 'btn btn-outline-info',
                'data' => [
                    'confirm' => 'Esti sigur ca vrei sa postezi anuntul? Odata postat anuntul nu mai poate fi modificat',
                    'method' => 'post',
                ],
            ]);
            echo '</p>';

            echo Html::a('Adauga post vacant', ['post-vacant/create', 'id' => $model->id], ['class' => 'btn btn-outline-primary']);
        }
        else
            echo '<h5 class="alert alert-warning">Anunt postat, nu se pot efectua modificari</h5>';
      ?>

    <br>
    <br>
    <h3>Incarca document nou:</h3>
    <?php
$form = \yii\widgets\ActiveForm::begin(); ?>

<?php
    Yii::$app->params['bsDependencyEnabled'] = false;
foreach($document as $key=>$d){
    echo $form->field($d,"[{$key}]fisiere")
        ->widget(\kartik\file\FileInput::className(),[
            'id'=>$key,
            'options'=>[
                'multiple'=>true,


            ],
            'pluginOptions'=>[
                'required'=>true,
                'showUpload' => false,
                'browseLabel'=>'Cauta',
                'removeLabel'=>'Sterge',
                'showPreview'=>false,
                'maxFileSize'=>'3072',

            ],

        ])->label('')->hint("Pentru incarcare multipla se selecteaza toate fisierele odata prin mentinerea tastei Ctrl");
    //echo $form->field($d, "[$key]id_nom_tip_fisier_dosar")->hiddenInput(['value' => $d->id_nom_tip_fisier_dosar])->label(false);
}

?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Confirma'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
    <?php \yii\widgets\ActiveForm::end(); ?>

    <br>
    <br>
    <h4>Fisierele anuntului:</h4>
    <br>
<?php

echo \yii\widgets\ListView::widget([

    'dataProvider'=>$fisiere,
    'itemView'=>'_fisier_item',
    'viewParams'=>['id_anunt'=>$id_anunt],
    'summary' =>''
]);?>

        <div >
            <?php
            if($nr_posturi>2){
                echo "<br><br><h1>Posturile anuntului</h1><br>";
                echo \yii\widgets\ListView::widget([

                'dataProvider'=>$posturi,
                'emptyText' => 'Acesta anunt nu are posturi asociate.',
                'itemView'=>'_post_item',
                'summary' =>''
                ]);
            }
            else if($nr_posturi==1){
                echo "<br><br><h2>Post Vacant:</h2><hr style='border-top: 2px solid black;'><br>";
                echo $this->renderFile(Yii::getAlias('@backend').'\views\post-vacant\view.php',[
                'model' => \common\models\PostVacant::find()->where(['id_anunt'=>$model->id])->one()
                ]);
            }
            else
                echo "Nu exista posturi in cadrul acestui anunt";
            ?>
        </div>
        <br>

        <?= Html::a('< Inapoi la Anunturi',['anunt/index'],['class'=>'btn btn-outline-primary'])?>




