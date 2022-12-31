<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CandidatFisier $model */

$this->title = 'Create Candidat Fisier';
$this->params['breadcrumbs'][] = ['label' => 'Candidat Fisiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidat-fisier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
