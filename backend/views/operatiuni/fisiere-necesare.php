<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $document */
/** @var \frontend\controllers\DocumenteUserController $existente */

?>

    <div class="documente-user-form">
        <h4>Selecteaza documentele pe care doresti sa le adaugi/stergi:</h4>
        <br>
        <?php $form = ActiveForm::begin(); ?>

        <?php
        foreach($document as $key=>$d) {
            $struct='';
            if($d->getNumeStructura()!=0)
            {
                $struct=" (".$d->getNumeStructura()." ) ";
            }

            if (in_array($d->id, $existente)) {
                echo $form->field($d, "[{$key}]nume")->checkbox(['checked' => true], false)->label(ucfirst($d->nume).$struct);
                echo $form->field($d, "[$key]id")->hiddenInput(['value' => $d->id])->label(false);
            } else {
                echo $form->field($d, "[{$key}]nume")->checkbox([], false)->label(ucfirst($d->nume).$struct);
                echo $form->field($d, "[$key]id")->hiddenInput(['value' => $d->id])->label(false);


            }
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Confirma'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <style>
        label {
            display: inline-flex;
            align-items: center;
        }
        label input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>

<?php ActiveForm::end(); ?>