<?php

use common\models\CandidatFisier;
use yii\helpers\Html;
use common\models\NomTipFisierDosar;
use common\models\KeyTipFisierDosarTipCategorie;
use common\models\Anunt;

/** @var \frontend\controllers\DocumenteUserController $id_post */
/** @var \frontend\controllers\DocumenteUserController $fisiere */
/** @var \frontend\controllers\DocumenteUserController $id_user */

    $verificare=CandidatFisier::find()->where(['id_user_adaugare'=>Yii::$app->user->identity->id])->asArray()->all();
    if(empty($verificare)) {
        $fis=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['p'=>\common\models\PostVacant::tableName()],'p.id_anunt=a.id')
            ->where(['p.id'=>$id_post])
            ->asArray()->all();
        $params=[
            'id_post' => $id_post,
            'fisiere' => $fis,
            'validare'=>4
        ];
        $security = Yii::$app->getSecurity();
        $encryptionKey = 'cheia_de_criptare_secreta';
        $dataToEncrypt = http_build_query($params);
        $encryptedData = $security->encryptByPassword($dataToEncrypt, $encryptionKey);
        Yii::$app->response->redirect(['/documente-user/create','params'=>$encryptedData]);
    }
    else {
        echo '<h4>S-au găsit documente înregistrate de dvs</h4><br>';
        echo Html::a('Folosește aceleași documente', ['/documente-user/samedoc','id_post'=>$id_post], ['class' => 'btn btn-info']);
        echo '<br>';
        echo "*În caz că nu există toate documentele necesare se va deschide un formular unde înregistrați documentele lipsă";
        echo '<br>';
        echo '<br>';

        $params=[
            'id_post' => $id_post,
            'fisiere' =>NomTipFisierDosar::find()
                ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
                ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
                ->innerJoin(['p'=>\common\models\PostVacant::tableName()],'p.id_anunt=a.id')
                ->where(['p.id'=>$id_post])
                ->asArray()->all(),
            'validare'=>4
        ];
        $security = Yii::$app->getSecurity();
        $encryptionKey = 'cheia_de_criptare_secreta';
        $dataToEncrypt = http_build_query($params);
        $encryptedData = $security->encryptByPassword($dataToEncrypt, $encryptionKey);
        echo Html::a('Încarcă toate documentele noi', ['/documente-user/create','params'=>$encryptedData], ['class' => 'btn btn-info']);
        echo '<br>';
        echo '<br>';


        echo Html::a('Actualizează doar o parte din documente', ['/documente-user/partial','id_post'=>$id_post], ['class' => 'btn btn-info']);
        echo '<br>';
        echo '<br>';

        echo '<h4> Aveți încărcate următoarele documente:</h4>';
        $fisiere_incarcate = common\models\NomTipFisierDosar::find()->select('nom_tip_fisier_dosar.nume')->distinct()
            ->innerJoin(['c' => CandidatFisier::tableName()], 'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_user_adaugare' => Yii::$app->user->identity->id])->asArray()->all();
        echo '<br><ul>';
        for($i=0;$i<count($fisiere_incarcate);$i++){
            echo "<h5><li class='bulina'>\t{$fisiere_incarcate[$i]['nume']}</li></h5><br>";
        }
        echo '</ul>';
        //editat
        echo '<h4> Pentru aplicare sunt necesare următoarele documente:</h4>';
        $fisiere_necesare=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['p'=>\common\models\PostVacant::tableName()],'p.id_anunt=a.id')
            ->where(['p.id'=>$id_post])
            ->asArray()->all();

        echo '<br><ul>';
        for($i=0;$i<count($fisiere_necesare);$i++){
            echo "<h5><li class='bulina'>\t{$fisiere_necesare[$i]['nume']}</li></h5><br>";

        }
        echo '</ul>';

    }
?>
<style>
    ul.bulina {
        list-style-type: circle;
    }

</style>

