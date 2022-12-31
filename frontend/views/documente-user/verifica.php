<?php

use common\models\CandidatFisier;
use yii\helpers\Html;
use common\models\NomTipFisierDosar;
use common\models\KeyTipFisierDosarTipCategorie;
use common\models\Anunt;
use common\models\KeyAnuntPostVacant;

/** @var \frontend\controllers\DocumenteUserController $id_post */
/** @var \frontend\controllers\DocumenteUserController $fisiere */
/** @var \frontend\controllers\DocumenteUserController $id_user */

    $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>Yii::$app->user->identity->id])->asArray()->all();
    if(empty($verificare)) {
        $fis=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
            ->where(['kk.id_post_vacant'=>$id_post])
            ->asArray()->all();
        Yii::$app->response->redirect(['/documente-user/create','id_post'=>$id_post,'fisiere'=>$fis]);
    }
    else {
        echo '<p>S-au gasit documente inregistrate de dvs</p>';
        echo Html::a('Foloseste aceleasi documente', ['/documente-user/samedoc','id_post'=>$id_post], ['class' => 'btn btn-primary']);
        echo "*In caz ca nu exista toate documentele necesare se va deschide un formular unde inregistrati documentmele lipsa";
        echo '<br>';
        echo '<br>';


        echo Html::a('Incarca toate documentele noi', ['/documente-user/create','id_post'=>$id_post,'fisiere'=>
            NomTipFisierDosar::find()
                ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
                ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
                ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
                ->where(['kk.id_post_vacant'=>$id_post])
                ->asArray()->all()
        ], ['class' => 'btn btn-primary']);
        echo '<br>';
        echo '<br>';


        echo Html::a('Actualizeaza doar o parte din documente', ['/documente-user/partial','id_post'=>$id_post], ['class' => 'btn btn-primary']);
        echo '<br>';
        echo '<br>';

        echo '<h4> Aveti incarcate documentele urmatoare:</h4>';
        $fisiere_incarcate = common\models\NomTipFisierDosar::find()->select('nom_tip_fisier_dosar.nume')->distinct()
            ->innerJoin(['c' => CandidatFisier::tableName()], 'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_user_adaugare' => 2])->asArray()->all();
        echo '<br>';
        for($i=0;$i<count($fisiere_incarcate);$i++){
            echo "<h5>\t- {$fisiere_incarcate[$i]['nume']}</h5>";
            echo '<br>';
        }

        echo '<h4> Pentru aplicare sunt necesare urmatoarele documente:</h4>';
        $fisiere_necesare=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
            ->where(['kk.id_post_vacant'=>$id_post])
            ->asArray()->all();
        echo '<br>';
        for($i=0;$i<count($fisiere_necesare);$i++){
            echo "<h5>\t- {$fisiere_necesare[$i]['nume']}</h5>";
            echo '<br>';
        }

    }
?>

