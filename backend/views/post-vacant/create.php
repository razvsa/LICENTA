<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */


$this->title = 'Creeaza Post Vacant';

?>
<br>
<div class="post-vacant-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
