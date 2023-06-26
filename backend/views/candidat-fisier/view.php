<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var \backend\controllers\CandidatFisierController $tip_fisier */
/** @var \backend\controllers\CandidatFisierController $fisiere */
/** @var \backend\controllers\CandidatFisierController $valid */
/** @var \backend\controllers\CandidatFisierController $id_user */
/** @var \backend\controllers\CandidatFisierController $stare */

$this->title = $tip_fisier;


\yii\web\YiiAsset::register($this);
?>
<div class="candidat-fisier-view">



<?php
    echo '<h3>'.ucfirst($tip_fisier).'</h3>';
    echo '<br>';
    echo \yii\helpers\Html::a("Descarcă", ['/candidat-fisier/descarcapartial','tip_fisier'=>$tip_fisier,'id_user'=>$id_user], ['class' => 'btn btn-success']) ;
    echo '<br>';
    echo '<br>';
    echo \yii\widgets\ListView::widget([
    'dataProvider' => $fisiere,
    'itemView' => '_document_item',
    'summary' => ''
    ]);
    echo '<hr>';

    ?>
    <?php
    if($valid==0) {

    }
    else{
        echo '<div class="alert alert-success" role="alert"> Document validat </div>';
    }

    ?>
</div>
