<?php

namespace backend\controllers;

use common\models\KeyTipFisierDosarTipCategorie;
use common\models\NomDepartament;
use common\models\NomNivelCariera;
use common\models\NomNivelStudii;
use common\models\NomStructura;
use common\models\NomTipCategorie;
use common\models\NomTipFisierDosar;
use common\models\NomTipIncadrare;
use common\models\PostVacant;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use function PHPUnit\Framework\isEmpty;
use kartik\dialog\Dialog;
use yii\web\JsExpression;
class OperatiuniController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['fisier-dosar','categorie','fisiere-necesare'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user=User::findOne(['id'=>\Yii::$app->user->id]);
                            if($user->admin==0)
                                return true;
                            else
                                return false;
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionNivelCariera()
    {

        $model = new NomNivelCariera();

        $nivel_cariera = new ActiveDataProvider([
            'query' => NomNivelCariera::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomNivelCariera::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save(false);
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                return $this->render('nivel-cariera',[
                    'model'=>$model,
                    'nivel_cariera'=>$nivel_cariera,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Nivel Cariera este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('nivel-cariera',[
            'model'=>$model,
            'nivel_cariera'=>$nivel_cariera,
        ]);
    }

    public function actionFisiereNecesare($id_categorie){

        if(\Yii::$app->user->getIdentity()->admin==0){
            $fisiere=NomTipFisierDosar::find()->asArray()->all();
        }
        else{
            $array_id = [0, \Yii::$app->user->getIdentity()->admin];
            $fisiere = NomTipFisierDosar::find()
                ->where(['id_structura' => $array_id])
                ->asArray()->all();
        }
        $existente=KeyTipFisierDosarTipCategorie::find()->where(['id_categorie'=>$id_categorie])->asArray()->all();
        $existente = array_column($existente, 'id_tip_fisier');
        $document=[];
        foreach ($fisiere as $f){
            $document[]=new NomTipFisierDosar();

        }
        echo Dialog::widget([
            'libName' => 'krajeeDialogConf',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                   
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);
        for($i=0;$i<count($fisiere);$i++){
            $document[$i]->nume = $fisiere[$i]['nume'];
            $document[$i]->id = $fisiere[$i]['id'];
            $document[$i]->id_structura = $fisiere[$i]['id_structura'];

        }
        if (Model::loadMultiple($document,\Yii::$app->request->post())&& Model::validateMultiple($document)) {
//            echo '<pre>';
//            print_r($rezultate);
//            echo '</pre>';
//            die();
            for($i=0;$i<count($fisiere);$i++)
            {
                if($document[$i]['nume']==1){
                    if(!in_array($document[$i]['id'],$existente)){
                        $model_key=new KeyTipFisierDosarTipCategorie();
                        $model_key->id_categorie=$id_categorie;
                        $model_key->id_tip_fisier=$document[$i]['id'];
//                        echo '<pre>';
//                        print_r($document);
//                        die;
//                        echo '</pre>';
                        $model_key->save();
                    }
                }
                else{
                    $verificare=KeyTipFisierDosarTipCategorie::find()
                        ->where(['id_categorie'=>$id_categorie,'id_tip_fisier'=>$document[$i]['id']])->all();
                    if($verificare!=null)
                        foreach ($verificare as $v)
                            $v->delete();
                }
            }
            $js = <<< JS
                krajeeDialogConf.dialog(
                "Modificare realizata cu succes",
                function() {
                }
                 );
                JS;
            $this->view->registerJs($js);
            $model = new NomTipCategorie();

            $tip_categorie = new ActiveDataProvider([
                'query' => NomTipCategorie::find(),
            ]);
            return $this->render('categorie',[
                'model'=>$model,
                'tip_categorie'=>$tip_categorie,
            ]);
        }

        for($i=0;$i<count($fisiere);$i++){
            $document[$i]->nume = $fisiere[$i]['nume'];
            $document[$i]->id = $fisiere[$i]['id'];
        }
         return $this->render('fisiere-necesare',[
            'document'=>$document,
            'existente'=>$existente,
         ]);
    }

    public function actionActualizeazaCariera($id){
        $model=NomNivelCariera::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('nivel-cariera');
        }
        return  $this->render('actualizeaza-cariera',[
            'model'=>$model,
            ]
        );
    }

    public function actionDeleteCariera($id){
        $model=NomNivelCariera::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('nivel-cariera');
    }

    public function actionCategorie()
    {

        $model = new NomTipCategorie();

        $tip_categorie = new ActiveDataProvider([
            'query' => NomTipCategorie::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomTipCategorie::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save();
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                return $this->render('categorie',[
                    'model'=>$model,
                    'tip_categorie'=>$tip_categorie,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('categorie',[
            'model'=>$model,
            'tip_categorie'=>$tip_categorie,
        ]);
    }
    public function actionActualizeazaCategorie($id){
        $model=NomTipCategorie::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('categorie');
        }
        return  $this->render('actualizeaza-categorie',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteCategorie($id){
        $model=NomTipCategorie::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('categorie');
    }

    public function actionDepartament()
    {

        $model = new NomDepartament();

        $departament = new ActiveDataProvider([
            'query' => NomDepartament::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomDepartament::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save();
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                return $this->render('departament',[
                    'model'=>$model,
                    'departament'=>$departament,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('departament',[
            'model'=>$model,
            'departament'=>$departament,
        ]);
    }
    public function actionActualizeazaDepartament($id){
        $model=NomDepartament::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('departament');
        }
        return  $this->render('actualizeaza-departament',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteDepartament($id){
        $model=NomDepartament::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('departament');
    }
    public function actionNivelStudii()
    {

        $model = new NomNivelstudii();

        $nivel_studii = new ActiveDataProvider([
            'query' => NomNivelStudii::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomNivelStudii::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save(false);
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                return $this->render('nivel-studii',[
                    'model'=>$model,
                    'nivel_studii'=>$nivel_studii,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('nivel-studii',[
            'model'=>$model,
            'nivel_studii'=>$nivel_studii,
        ]);
    }
    public function actionActualizeazaStudii($id){
        $model=NomNivelStudii::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('nivel-studii');
        }
        return  $this->render('actualizeaza-studii',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteStudii($id){
        $model=NomNivelStudii::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('nivel-studii');
    }

    public function actionFisierDosar()
    {

        $structura=\common\models\NomStructura::find()->all();
        $structura_map=\yii\helpers\ArrayHelper::map($structura,'id','nume');
        $structura_finala=[];
        $structura_finala[0]='TOATE STRUCTURILE';
        $structura_finala=array_merge($structura_finala,$structura_map);
        $model = new NomTipFisierDosar();

        $fisier_dosar = new ActiveDataProvider([
            'query' => NomTipFisierDosar::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomTipFisierDosar::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                if(\Yii::$app->user->getIdentity()->admin!=0){
                    $model->id_structura=\Yii::$app->user->getIdentity()->admin;
                }
                $model->save();
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                $model->id_structura=null;
                return $this->render('fisier-dosar',[
                    'model'=>$model,
                    'fisier_dosar'=>$fisier_dosar,
                    'structura_finala'=>$structura_finala,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('fisier-dosar',[
            'model'=>$model,
            'fisier_dosar'=>$fisier_dosar,
            'structura_finala'=>$structura_finala,
        ]);
    }
    public function actionActualizeazaFisierDosar($id){
        $model=NomTipFisierDosar::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('fisier-dosar');
        }
        return  $this->render('actualizeaza-fisier-dosar',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteFisierDosar($id){
        $model=NomTipFisierDosar::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('fisier-dosar');
    }
    public function actionTipIncadrare()
    {

        $model = new NomTipIncadrare();

        $tip_incadrare= new ActiveDataProvider([
            'query' => NomTipIncadrare::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomTipIncadrare::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save(false);
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                return $this->render('tip-incadrare',[
                    'model'=>$model,
                    'tip_incadrare'=>$tip_incadrare,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('tip-incadrare',[
            'model'=>$model,
            'tip_incadrare'=>$tip_incadrare,
        ]);
    }
    public function actionActualizeazaTipIncadrare($id){
        $model=NomTipIncadrare::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('tip-incadrare');
        }
        return  $this->render('actualizeaza-tip-incadrare',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteTipIncadrare($id){
        $model=NomTipIncadrare::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('tip-incadrare');
    }
    public function actionTipStructura()
    {

        $model = new NomStructura();

        $tip_structura= new ActiveDataProvider([
            'query' => NomStructura::find(),
        ]);


        echo Dialog::widget([
            'libName' => 'krajeeDialogCust1',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_DANGER,
                'title' => 'Eroare',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-1',
                        'label' => 'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        echo Dialog::widget([
            'libName' => 'krajeeDialogCust2',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => '',
                'message' => '',
                'buttons' => [
                    [
                        'id' => 'cust-btn-2',
                        'label'=>'OK',
                        'action' => new JsExpression("function(dialog) {
                    dialog.close();
                }")
                    ]
                ],
                'buttonsAlign' => 'right',
                'closeButton' => false,
            ]
        ]);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $verificare = NomStructura::find()->where(['nume' => $model->nume])->asArray()->all();

            if (empty($verificare)) {
                $js = <<< JS
                krajeeDialogCust2.dialog(
                "Adaugat cu succes!",
                function() {}
                );
                JS;
                $model->save(false);
                $this->view->registerJs($js);
                $model->nume=null;
                $model->id=null;
                $model2=new NomStructura();
                return $this->render('tip-structura',[
                    'model'=>$model2,
                    'tip_structura'=>$tip_structura,
                ]);

            }
            else {
                $js = <<< JS
                krajeeDialogCust1.dialog(
                "Aceasta optiune pentru Categorie posturi este deja inregistrata",
                function() {}
                 );
                JS;
                $this->view->registerJs($js);
            }
        }

        return $this->render('tip-structura',[
            'model'=>$model,
            'tip_structura'=>$tip_structura,
        ]);
    }
    public function actionActualizeazaTipStructura($id){
        $model=NomStructura::findOne(['id'=>$id]);
        if($this->request->isPost && $model->load($this->request->post()))
        {
            $model->save();
            $this->redirect('tip-structura');
        }
        return  $this->render('actualizeaza-tip-structura',[
                'model'=>$model,
            ]
        );
    }
    public function actionDeleteTipStructura($id){
        $model=NomStructura::findOne(['id'=>$id]);
        $model->delete();
        $this->redirect('tip-structura');
    }
}
