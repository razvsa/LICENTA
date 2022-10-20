<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Jobs $model */

$this->title = $model->Denumire;
\yii\web\YiiAsset::register($this);
?>
<div class="jobs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class='merge'>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Denumire',
            'Oras',
            'Departament',
            'Tip',
            'Nivel_studii',
            'Nivel_cariera',
            'Salariu',
        ],
    ]) ?>
</div>
</div>
