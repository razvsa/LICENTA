<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */

$this->title = 'Update Post Vacant: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Vacants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-vacant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
