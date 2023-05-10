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
Yii::$app->params['bsDependencyEnabled'] = false;
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

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<div class="container-fluid ">
    <!-- Sidebar -->
    <div class="mysidebar"  >
        <h3 >Filtreaza</h3>
        <?php echo $this->render('_search', ['model' => $searchModel,'functie'=>$functie,'nivel_studii'=>$nivel_studii,'nivel_cariera'=>$nivel_cariera]); ?>
    </div>

    <!-- Page Content -->
    <div class="mypgcontent" >
        <?php
        Pjax::begin(['id'=>'anunt_search_pjax']);
        echo '<br><h5>Au fost gasite <b>'.$dataProvider->count.'</b> anunturi  </h5><br>';
        echo \yii\widgets\ListView::widget([

            'dataProvider'=>$dataProvider,
            'itemView'=>'_jobs_item',
            'summary' =>''
        ]);
        Pjax::end();?>

    </div>

</div>
<style>
    @media only screen and (min-width: 800px) {
        .mysidebar{
            margin-right:80%;
            height:80%;
            width:200px;
            background-color:#fff;
            position:fixed!important;
            z-index:1;
            overflow:auto}

        .mypgcontent{
            margin-left:30%;
            margin-right: 5%;

        }

        }
    }
    @media only screen and (max-width: 800px) {
        .mysidebar {
            margin-left:20%
            overflow: auto;
        }
        .mypgcontent{

            margin-left:0%
        }
    }
</style>

