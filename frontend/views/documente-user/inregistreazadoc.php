<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\DocumenteUserController $documente */
?>

    <div class="documente-user-form">
        <h4>Selectează documentele pe care dorești să le încarci:</h4>

        <?php
        $form = ActiveForm::begin(); ?>

        <?php

        foreach($documente as $key=>$d) {
            echo $form->field($d, "[{$key}]nume")->checkbox([], false)->label($d->nume);
            echo $form->field($d, "[$key]id")->hiddenInput(['value' => $d->id])->label(false);
        }

        ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Confirmă'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
