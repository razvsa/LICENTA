<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */

$this->title = 'Actulizeaza Anunt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anunturi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizeaza';
?>
<div class="anunt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
