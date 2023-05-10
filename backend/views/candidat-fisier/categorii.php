 <?php
/** @var \backend\controllers\CandidatFisierController $id_user */
/** @var \backend\controllers\CandidatFisierController $tip_fisier */
/** @var \backend\controllers\CandidatFisierController $stare */
?>
<h3>
    Fisiere incarcate
</h3>
<br>
<div >
    <?php

        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$tip_fisier,
            'itemView'=>'_categorii_item',
            'viewParams' => ['id_user' => $id_user,'stare'=>$stare],
            'summary' =>''
        ]);
        echo \yii\helpers\Html::a('< Inapoi la utilizatori',['/candidat-fisier/user','stare'=>$stare],['class'=>'btn btn-outline-info']);
        if($stare==3)
        {
            echo '<br>';
            echo '<br>';
            echo \yii\helpers\Html::a('Descarcati toate documentele',['/candidat-fisier/descarcatot','id_user'=>$id_user],['class'=>'btn btn-outline-success']);
        }
        ?>

</div>




