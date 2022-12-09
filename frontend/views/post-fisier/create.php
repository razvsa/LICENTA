<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostFisier $model */

$this->title = 'Create Post Fisier';
$this->params['breadcrumbs'][] = ['label' => 'Post Fisiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-fisier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'document'=>$document,
    ]) ?>

</div>
