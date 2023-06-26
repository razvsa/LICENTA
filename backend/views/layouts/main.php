<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
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
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    if(\Yii::$app->user->getIdentity()->admin==0)
        $menuItems = [
        ['label' => 'Anunțuri', 'url' => ['/anunt/index'],'class'=>'mx-auto'],
        [
            'label' => 'Operațiuni',
            'items' => [
                ['label' => 'Nivel Carieră', 'url' => ['/operatiuni/nivel-cariera']],
                ['label' => 'Categorie Posturi', 'url' => ['/operatiuni/categorie']],
                ['label' => 'Nivel Studii', 'url' => ['/operatiuni/nivel-studii']],
                ['label' => 'Documente dosar', 'url' => ['/operatiuni/fisier-dosar']],
                ['label' => 'Tip încadrare', 'url' => ['/operatiuni/tip-incadrare']],
                ['label' => 'Structură', 'url' => ['/operatiuni/tip-structura']],
            ],

        ],
        ['label' => 'Utilizatori', 'url' => ['/user/index'],'class'=>'mx-auto'],

    ];
    else
        $menuItems = [
            ['label' => 'Anunțuri', 'url' => ['/anunt/index'],'class'=>'mx-auto'],
            [
                'label' => 'Dosare',
                'items' => [
                    ['label' => 'De aprobat', 'url' => ['/candidat-fisier/posturi','status'=>1]],
                    ['label' => 'Aprobate', 'url' => ['/candidat-fisier/posturi','status'=>3]],
                    ['label' => 'Incomplete', 'url' => ['/candidat-fisier/posturi','status'=>4]],
                    ['label' => 'Respinse', 'url' => ['/candidat-fisier/posturi','status'=>2]],
                ],
            ],
            [
                'label' => 'Operațiuni',
                'items' => [
                    ['label' => 'Documente dosar', 'url' => ['/operatiuni/fisier-dosar']],
                ],
            ],



        ];


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
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
