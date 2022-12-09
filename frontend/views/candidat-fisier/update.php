<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CandidatFisier $model */

$this->title = 'Update Candidat Fisier: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Candidat Fisiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="candidat-fisier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
