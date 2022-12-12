<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */

$this->title = 'Update Documente User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documente Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documente-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>