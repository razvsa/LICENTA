<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */

$this->title = 'Actulizează Anunț: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anunțuri', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizează';
?>
<div class="anunt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
