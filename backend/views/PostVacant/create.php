<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */

$this->title = 'Create Post Vacant';
$this->params['breadcrumbs'][] = ['label' => 'Post Vacants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-vacant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
