<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CandidatFisier $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Candidat Fisiers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="candidat-fisier-view">

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
    <?php
    for($i=0;$i<3;$i++) {
        echo '<iframe width="auto" height="500px" src="http://ejobs.mai.gov.ro/storage/user_2/document_2_1_test2_CV(' . $i . ').png"></iframe>';
        echo '<br>';
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cale_fisier',
            'data_adaugare',
            'descriere',
            'id',
            'id_user_adaugare',
            'nume_fisier_afisare',
            'nume_fisier_adaugare',
            'id_nom_tip_fisier_dosar',
            'stare',
        ],
    ])

    ?>
    <?php echo Html::a('Aproba',['/candidat-fisier/aproba','id'=>$model->id],['class'=>'btn btn-success'])?>

    <?php echo Html::a('Respinge',['/candidat-fisier/respinge','id'=>$model->id],['class'=>'btn btn-danger'])?>

</div>
