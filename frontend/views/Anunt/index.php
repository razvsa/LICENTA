<?php

use common\models\Anunt;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var common\models\search\AnuntSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \frontend\controllers\AnuntController $localitati */
/** @var \frontend\controllers\AnuntController $functie */
/** @var \frontend\controllers\AnuntController $nivel_studii */
/** @var \frontend\controllers\AnuntController $nivel_cariera */

$this->title = 'Anunturi';

?>
        <?php
        $script=<<<JS
        $('body').on('beforeSubmit', 'form#anunt_search', function(event) {
            console.log("aici");
            var form = $(this);
            if (form.find('.has-error').length) {
                return false;
            }
            $.get(
                form.attr('action'),
                form.serialize()
            ).done(function(result){

                var url = form.attr('action') + '?' + form.serialize();
                $.pjax.reload("#anunt_search_pjax",{url: url});  //Reload GridView

            }).fail(function(){
                var url = form.attr('action');
                $.pjax.reload("#anunt_search_pjax",{ push: false,  url: url});
            });
            return false;
        });
JS;
        $this->registerJs($script,\yii\web\View::POS_READY);
        ?>
<div class="anunt-index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <!-- Sidebar -->
    <div class="w3-sidebar" style="width:18%" >
        <h3 class="w3-bar-item">Filtreaza</h3>
        <?php echo $this->render('_search', ['model' => $searchModel,'functie'=>$functie,'nivel_studii'=>$nivel_studii,'nivel_cariera'=>$nivel_cariera]); ?>
    </div>

    <!-- Page Content -->
    <div style="margin-left:25%">
        <?php
        Pjax::begin(['id'=>'anunt_search_pjax']);
        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$dataProvider,
            'itemView'=>'_jobs_item',
            'summary' =>''
        ]);
        Pjax::end();?>

    </div>

</div>