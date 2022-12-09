<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostFisier $model */

$this->title = 'Update Post Fisier: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Fisiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-fisier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
