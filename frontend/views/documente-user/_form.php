<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;
/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $document */
/** @var \frontend\controllers\DocumenteUserController $mesaj */
?>

<div class="documente-user-form">

    <?php $form = ActiveForm::begin([
            'id'=>'form-id'
    ]);
        if($mesaj==!"")
            echo "<h4 class='alert alert-danger'>$mesaj</h4>";
    ?>



<?php
    Yii::$app->params['bsDependencyEnabled'] = false;
//echo '<pre>';
//print_r($document);
//die;
//echo '</pre>';
    foreach($document as $key=>$d){
      echo $form->field($d,"[{$key}]fisiere")
    ->widget(FileInput::className(),[
                'id'=>$key,
                'options'=>[
                        'multiple'=>true,


                ],
                'pluginOptions'=>[
                        'required'=>true,
                        'showUpload' => false,
                        'browseLabel'=>'Căuta',
                        'removeLabel'=>'Șterge',
                        'showPreview'=>false,
                        'maxFileSize'=>'3072',

                ],

        ])->label( ucfirst($d->nomTipFisierDosar->nume))->hint("Pentru încarcare multiplă se selectează toate fișierele odată prin menținerea tastei Ctrl. Documente acceptate: .pdf, .jpeg, .jpg, .png");
        echo $form->field($d, "[$key]id_nom_tip_fisier_dosar")->hiddenInput(['value' => $d->id_nom_tip_fisier_dosar])->label(false);

    }

?>
    <div id="spinner" style="display: none;">
        <div class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Confirmă'), ['class' => 'btn btn-success']) ?>
    </div>


</div>
    <?php ActiveForm::end(); ?>
<style>
    .spinner-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }

    .spinner {
        border: 4px solid #f3f3f3; /* culoarea de fundal */
        border-top: 4px solid #3498db; /* culoarea spinner-ului */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
<script>
    // Funcție pentru afișarea spinner-ului
    function showSpinner() {
        document.getElementById("spinner").style.display = "block";
    }
</script>
<script>
    $(document).ready(function() {
        $('#form-id').on('beforeSubmit', function(e) {
            showSpinner();
            return true; // Pentru a permite trimiterea formularului
        });
    });
</script>
