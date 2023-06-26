<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Conectează-te';

?>
<div class="site-login" >

    <div class="row">
        <div class="col-lg-5">

        </div>
    </div>

<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://ejobs.mai.gov.ro/storage/Loginbck.PNG"
                     class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="form-outline mb-4">
                <?=  $form->field($model, 'username')->textInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Introduceți username'])
                    ->label("Username") ?>
                </div>
                <div class="form-outline mb-3">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Introduceți parola']) ?>
                </div>

                <div class="my-1 mx-0" ">
                    Dacă ai uitat parola o poți  <?= Html::a('Reseta', ['site/request-password-reset'],['class'=>'link-info']) ?>.
                    <br>

                    Ai nevoie de un nou link de activare?  <?= Html::a('Retrimite', ['site/resend-verification-email'],['class'=>'link-info']) ?>
                </div>
                <br>

                <div class="form-group">
                    <?= Html::submitButton('Conectează-te', ['class' => 'btn btn-info  btn-lg', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</section>
</div>
<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .h-custom {
        height: calc(100% - 74px);
    }
    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }

</style>