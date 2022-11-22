<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Vacants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-vacant-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_nom_tip_functie',
            'pozitie_stat_organizare',
            'denumire',
            'cerinte',
            'id_nom_judet',
            'id_nom_nivel_studii',
            'id_nom_nivel_cariera',
            'oras',
        ],
    ]) ?>
    <?php
    if (Yii::$app->user->isGuest) {
        echo "<p>Trebuie sa fii autentificat pentru a aplica pentru acest post</p>";
        echo Html::a("Conecteaza-te",['site/login'],['class'=>'btn btn-primary']);
    } else {
        echo Html::a("Aplica pentru acest post",[''],['class'=>'btn btn-primary']);
    }
    ?>
</div>
