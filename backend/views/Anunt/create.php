<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */

$this->title = 'Adaugă Anunț';
?>
<div class="anunt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
