<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;

/** @var yii\web\View $this */
/** @var common\models\PostVacant $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \frontend\controllers\PostVacantController $id_anunt */
$this->title = $model->denumire;
\yii\web\YiiAsset::register($this);
?>
<div class="post-vacant-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr style='border-top: 1px solid black;'>
    <br>
    <!-- Portfolio Item Row -->
    <div class="row">

        <div class="col-md-12">
            <?php
            $tip_functie=\common\models\NomTipIncadrare::find()->where(['id'=>$model->id_nom_tip_functie])->asArray()->all();

            $localitate=\common\models\NomLocalitate::find()->where(['id'=>$model->oras])->all();
            $judet=\common\models\NomJudet::find()->where(['id'=>$model->id_nom_judet])->all();
            $nivel_studii=\common\models\NomNivelStudii::find()->where(['id'=>$model->id_nom_nivel_studii])->all();
            $nivel_cariera=\common\models\NomNivelCariera::find()->where(['id'=>$model->id_nom_nivel_cariera])->all();
            $data=$model->getInscriereConcurs();

            ?>

            <p style="font-size:17px"><b>Denumire: </b> <?=$model->denumire?></p>
            <p style="font-size:17px"><b>Județ:</b> <?= $judet[0]['nume']?></p>
            <p style="font-size:17px"><b>Localitate: </b> <?=$localitate[0]['nume']?></p>
            <p style="font-size:17px"><b>Tip funcție: </b> <?=$tip_functie[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel studii: </b> <?=$nivel_studii[0]['nume']?></p>
            <p style="font-size:17px"><b>Nivel carieră: </b> <?=$nivel_cariera[0]['nume']?></p>
            <p style="font-size:17px"><b>Dată limită înscriere: </b> <?=$model->getInscriereConcurs()?></p>
        </div>

    </div>

    <?php
    if (Yii::$app->user->isGuest) {
        echo "<p>Trebuie să fii autentificat pentru a aplica pentru acest post</p>";
        echo Html::a("Conectează-te",['site/login'],['class'=>'btn btn-primary']);
    }
    else {
        $verificare=\common\models\KeyInscrierePostUser::find()->where(['id_user'=>Yii::$app->user->identity->id,'id_post'=>$model->id])->asArray()->all();
        $gasit=0;
        if(empty($verificare)) {
            //editare kap
            $anunturi=\common\models\KeyInscrierePostUser::find()
               ->innerJoin(['p'=>\common\models\PostVacant::tableName()],'p.id=key_inscriere_post_user.id_post')
               ->where(['key_inscriere_post_user.id_user'=>Yii::$app->user->identity->id])->select(['p.id_anunt'])->asArray()->all();
           for($i=0;$i<count($anunturi);$i++)
           {
               if($anunturi[$i]['id_anunt']==$model->id_anunt)
                   $gasit=1;
           }
            if($gasit==1){
                echo '<p class="alert alert-warning" role="alert">Ai aplicat deja pentru un post din anuntul curent</p>';
            }
            else {
                if(time()+3602>strtotime($model->getInscriereConcurs()))
                    echo '<p class="alert alert-danger" role="alert">Nu mai poti aplica pentru acest post deoarce a expirat timpul</p>';

                else {
                    echo Html::a("Aplică pentru acest post", ['/documente-user/verifica', 'id_post' => $model->id], ['class' => 'btn btn-outline-info']);
                    echo '<br>';
                    echo '<br>';
                    echo '<div class="container"><h1 id="headline">Au mai ramas :</h1><div id="countdown"><ul id="ul" class="d-flex justify-content-around"><li><span id="days"></span>ZILE</li><li><span id="hours"></span>ORE</li><li><span id="minutes"></span>MINUTE</li><li><span id="seconds"></span>SECUNDE</li></ul></div></div>';
                    echo '<br>';
                }
            }
        }
       else{
           echo '<p class="alert alert-success" role="alert">Ai aplicat deja pentru acest post</p>';
           echo Html::a('Renunta la acest post',['/post-vacant/renunta','id_post'=>$model->id,'id_user'=>Yii::$app->user->identity->id],['class'=>'btn btn-outline-danger','data' => [
               'confirm' => 'Esti sigur ca vrei sa renunti la acest post? Renuntarea implica stergerea completa a dosarului si imposibilitatea de a reveni',
               'method' => 'post',
           ],]);
       }
    }?>
    <br>
    <br>
<?php

    $class_step_inscriere='timeline-stepp mb-0';
    $class_step_validare='timeline-stepp mb-0';
    $class_step_sustinere='timeline-stepp mb-0';
    $class_inner_inscriere='inner-circlee';
    $class_inner_validare='inner-circlee';
    $class_inner_sustinere='inner-circlee';
    $data_postare=$model->data_postare;
    $data_validare='';
    $data_inscriere='';
    $data_concurs='';

    if(!Yii::$app->user->isGuest) {
        $user=\common\models\User::findOne(['id'=>Yii::$app->user->identity->id]);

        if ($user->getInscrierePost($model->id) != 0) {
            $class_inner_inscriere = 'inner-circle';
            $class_step_inscriere = 'timeline-step mb-0';
            $data_inscriere = $user->getInscrierePost($model->id);
        }
        if ($user->getValidareDocumente($model->id) == 1 && $user->getInscrierePost($model->id) != 0) {
            $class_inner_validare = 'inner-circle';
            $class_step_validare = 'timeline-step mb-0';
            $data_validare = "Toate diocumentele necesare postului sunt validate";
        }
        $data_concurs = $model->getDataConcurs();
        $data_concurs_time = strtotime($data_concurs);
        if (time() - $data_concurs_time >= 0 && $user->getValidareDocumente($model->id) == 1 && $user->getInscrierePost($model->id) != 0) {
            $class_inner_sustinere = 'inner-circle';
            $class_step_sustinere = 'timeline-step mb-0';
        }
    }
    ?>
    <style>
        body{margin-top:20px;}
        .timeline-steps {
            display: flex;
            justify-content: center;
            flex-wrap: wrap
        }

        .timeline-steps .timeline-step {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }
        .timeline-steps .timeline-stepp {
            align-items: center;
            display: flex;
            flex-direction: column;
            position: relative;
            margin: 1rem
        }

        @media (min-width:768px) {
            .timeline-steps .timeline-step:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #12a31a;
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-stepp:not(:last-child):after {
                content: "";
                display: block;
                border-top: .25rem dotted #5c6b72;
                width: 3.46rem;
                position: absolute;
                left: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-step:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #12a31a;
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem
            }
            .timeline-steps .timeline-stepp:not(:first-child):before {
                content: "";
                display: block;
                border-top: .25rem dotted #5c6b72;
                width: 3.8125rem;
                position: absolute;
                right: 7.5rem;
                top: .3125rem
            }
        }

        .timeline-steps .timeline-content {
            width: 10rem;
            text-align: center
        }

        .timeline-steps .timeline-content .inner-circle {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #12a31a
        }
        .timeline-steps .timeline-content .inner-circlee {
            border-radius: 1.5rem;
            height: 1rem;
            width: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #5c6b72
        }

        .timeline-steps .timeline-content .inner-circle:before {
            content: "";
            background-color: #12a31a;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }
        .timeline-steps .timeline-content .inner-circlee:before {
            content: "";
            background-color: #5c6b72;
            display: inline-block;
            height: 3rem;
            width: 3rem;
            min-width: 3rem;
            border-radius: 6.25rem;
            opacity: .5
        }


    </style>
    <br>
    <div class="container">
        <div class="row text-center justify-content-center mb-5">
            <div class="col-xl-6 col-lg-8">
                <h2 class="font-weight-bold">Evoluție</h2>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                    <div class="timeline-step">
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                            <div class="inner-circle"></div>
                            <p class="h6 mt-3 mb-1"><?=$data_postare?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Postare concurs</p>
                        </div>
                    </div>
                    <div class=<?=$class_step_inscriere?>>
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                            <div class=<?=$class_inner_inscriere?>></div>
                            <p class="h6 mt-3 mb-1"><?=$data_inscriere?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Înscriere și încărcare documente</p>
                        </div>
                    </div>
                    <div class=<?=$class_step_validare?>>
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                            <div class=<?=$class_inner_validare?>></div>
                            <p class="h6 mt-3 mb-1"><?=$data_validare?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Validare documente</p>
                        </div>
                    </div>
                    <div class=<?=$class_step_sustinere?>>
                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2020">
                            <div class=<?=$class_inner_sustinere?>></div>
                            <p class="h6 mt-3 mb-1"><?=$data_concurs?></p>
                            <p class="h6 text-muted mb-0 mb-lg-0">Susținere examen concurs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

        <h4><b>Cerințe: </b></h4><hr style='border-top: 1px solid black;'><p> <?=HTMLPurifier::process($model->cerinte)?></p><br>
        <h4><b>Tematică: </b></h4><hr  style='border-top: 1px solid black;'><p><?=HtmlPurifier::process($model->tematica)?></p><br>
        <h4><b>Bibliografie: </b></h4><hr  style='border-top: 1px solid black;'><p><?=HtmlPurifier::process($model->bibliografie)?></p><br>
    </div>
</div>
<script>

    (function () {
        var distance=10;
        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;
        var done = false;

        //I'm adding this section so I don't have to keep updating this pen every year :-)
        //remove this if you don't need it
        let today = new Date(),
            dd = String(today.getDate()).padStart(2, "0"),
            mm = String(today.getMonth() + 1).padStart(2, "0"),
            yyyy = today.getFullYear(),
            data_councurs = '<?=$data?>';

        today = mm + "/" + dd + "/" + yyyy;
        //end

        const countDown = new Date(data_councurs).getTime()
        const now = new Date().getTime()
        if(countDown > now) {
            const x = setInterval(function () {

                const now = new Date().getTime()
                const distance = countDown - now;

                //do something later when date is reached
                if (distance < 0) {
                    location.reload();
                    clearInterval(x);
                }
                else {
                    document.getElementById("days").innerText = Math.floor(distance / (day)),
                        document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                        document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                        document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
                }
                //seconds
            }, 0);
        }

    }());

</script>
<style>

    li {
        display: inline-block;
    }

    li span {
        display: block;
        font-size: 2.5rem;
    }

</style>


