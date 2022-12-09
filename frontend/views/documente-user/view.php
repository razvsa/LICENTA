<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\DocumenteUser $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documente Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="documente-user-view">

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
            'CV',
            'diploma_bacalaureat',
            'diploma_licenta',
            'diploma_master',
            'act_identitate',
            'carnet_munca',
            'adeaverinta_vechime_munca',
            'livret_militar',
            'certificat_nastere',
            'certificat_casatorie',
            'certificat_nastere_partener',
            'certificat_nastere_copii',
            'autobiografie',
            'tabel_nominal_rude',
            'cazier',
            'fotografie',
            'adeverinta_medic_familie',
            'consintamant_informat',
            'aviz_psihologic',
            'declaratie_de_conformitate',
        ],
    ]) ?>

</div>
