<?php

use yii\helpers\Html;
use kartik\dialog\DialogAsset;
use kartik\dialog\Dialog;
/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var \frontend\controllers\DocumenteUserController $document */
/** @var \frontend\controllers\DocumenteUserController $tip_fisier */
$this->title = 'Inregistreaza documente';
Yii::$app->params['bsDependencyEnabled'] = false;
?>
<div class="documente-user-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
        'document'=>$document,
        'tip_fisier'=>$tip_fisier,
    ]) ?>

</div>