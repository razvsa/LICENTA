<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <style>
        .my-custom-button {
            background-color: red;
            color: white;
        }
    </style>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
<?php
$this->registerCssFile('@web/css/toastify.css');
$this->registerJsFile('@web/js/toastify.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://js.pusher.com/7.2/pusher.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$canal="my-channel".Yii::$app->user->id;
$this->registerJs(<<<JS
$(document).ready(function() {

        var pusher = new Pusher('2eb047fb81e4d1cc5937', {
            cluster: 'eu'
        });
        var myButton = document.getElementById('button-notificare');
        var channel = pusher.subscribe('$canal');
        channel.bind('my-event', function(data) {
            if(myButton!=null)
            {
                myButton.style.setProperty("font-weight", "bold");
            }
            Toastify({
            text: "Ai notificari noi",
            duration: 4000,
            gravity: "top-right",
            position: "right",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
        }).showToast();
        });
    });
JS);
        $color="color: #000;";
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => '/anunt/index',
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Anunțuri', 'url' => ['/anunt/index']],


        ];
        if(!Yii::$app->user->isGuest){
            $count=\common\models\Notificare::find()->where(['stare_notificare'=>2])->count();
            if($count>0) {
                $menuItems = [
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Anunțuri', 'url' => ['/anunt/index']],
                    ['label' => 'Documentele mele', 'url' => ['/candidat-dosar/index']],
                    ['label' => 'Aplicările mele', 'url' => ['/anunt/anunturilemele']],
                    ['label' => 'Notificări', 'url' => ['/notificare/index'], 'options' => ['id' => 'button-notificare'],'linkOptions' => ['style' => 'font-weight:bold;']],

                ];
            }
            else{
                $menuItems = [
                    ['label' => 'Anunțuri', 'url' => ['/anunt/index']],
                    ['label' => 'Documentele mele', 'url' => ['/candidat-dosar/index']],
                    ['label' => 'Aplicările mele', 'url' => ['/anunt/anunturilemele']],
                    ['label' => 'Notificări', 'url' => ['/notificare/index'], 'options' => ['id' => 'button-notificare']],
                ];
            }
        }
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Înregistrează-te', 'url' => ['/site/signup']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::tag('div',Html::a('Conectează-te',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
        } else {
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    'Deconectează-te (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none']
                )
                . Html::endForm();
        }
        NavBar::end();

        ?>
    </header>

    <main role="main" class="flex-shrink-0 ">
        <div class="container ">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>



    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
?>
<style>

    .margin{
        margin-right:20px;
    }
    .newClass{
        font-weight: bold;
    }
</style>

