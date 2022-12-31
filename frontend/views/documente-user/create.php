<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */
/** @var \frontend\controllers\DocumenteUserController $document */
/** @var \frontend\controllers\DocumenteUserController $tip_fisier */
$this->title = 'Create Documente User';
?>
<div class="documente-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'document'=>$document,
        'tip_fisier'=>$tip_fisier,
    ]) ?>

</div>