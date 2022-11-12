<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anunts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="anunt-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_user_adaugare',
            'data_postare',
            'data_concurs',
            'data_depunere_dosar',
            'oras',
            'departament',
        ],
    ]) ?>

</div>
