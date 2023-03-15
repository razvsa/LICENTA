<?php
/** @var backend\controllers\CandidatFisierController $useri */
/** @var backend\controllers\CandidatFisierController $stare */

?>

<?php
    if($stare==2)
        echo '<h3>Documente de aprobat</h3>';
    else
        echo '<h3>Documente aprobate</h3>';
    echo '<br>';
?>


<div >
    <?php
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$useri,
        'itemView'=>'_user_item',
        'viewParams' => ['stare' => $stare],
        'summary' =>''
    ])?>
</div>