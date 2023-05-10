<?php
/** @var backend\controllers\CandidatFisierController $useri */
/** @var backend\controllers\CandidatFisierController $status */

?>

<?php
    if($status==2)
        echo '<h3>Dosare de aprobat</h3>';
    else if($status==3)
        echo '<h3>Dosare aprobate</h3>';
    echo '<br>';
?>


<div >
    <?php
    echo \yii\widgets\ListView::widget([

        'dataProvider'=>$useri,
        'itemView'=>'_user_item',
        'viewParams' => ['status' => $status],
        'summary' =>''
    ])?>
</div>