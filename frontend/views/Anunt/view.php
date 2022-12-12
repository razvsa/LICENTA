<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Anunt $model */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anunturi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="anunt-view">

    <h1><?= Html::encode('Posturile anuntului'.$this->title) ?></h1>

    <?= Html::a('Adauga post', ['post-vacant/index','id'=>$model->id], ['class' => 'btn btn-success']) ?>
</div>
