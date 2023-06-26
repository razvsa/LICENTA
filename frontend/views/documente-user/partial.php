<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $document */
?>

    <div class="documente-user-form">
        <h4>Selectează documentele pe care dorești să le actualizezi:</h4>
        <br>
        <?php $form = ActiveForm::begin(); ?>

        <?php

            foreach($document as $key=>$d) {
                echo $form->field($d, "[{$key}]nume")->checkbox([], false)->label($d->nume);
                echo $form->field($d, "[$key]id")->hiddenInput(['value' => $d->id])->label(false);
            }
        ?>
        <p>*Posibil să trebuiască să încarci documente în plus fața de cele selectate, în funcție de documentele necesare postului </p>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>