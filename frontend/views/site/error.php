<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<!--<div class="site-error">-->
<!---->
<!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <div class="alert alert-danger">-->
<!--        --><?php //= nl2br(Html::encode($message)) ?>
<!--    </div>-->
<!---->
<!--    <p>-->
<!--        The above error occurred while the Web server was processing your request.-->
<!--    </p>-->
<!--    <p>-->
<!--        Please contact us if you think this is a server error. Thank you.-->
<!--    </p>-->
<!---->
<!--</div>-->
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode('A apărut o eroare în timpul procesării cererii dumneavoastră.')) ?>
    </div>
    <p>
        Vă rugăm să încercați din nou sau să contactați administratorul site-ului dacă problema persistă.
    </p>
</div>
