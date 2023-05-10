<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CandidatDosar $model */

$this->title = 'Create Candidat Dosar';
$this->params['breadcrumbs'][] = ['label' => 'Candidat Dosars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidat-dosar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
