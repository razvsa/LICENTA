<?php

namespace frontend\controllers;

use common\models\Anunt;
use common\models\DocumenteUser;
use common\models\CandidatFisier;
use common\models\KeyAnuntPostVacant;
use common\models\KeyInscrierePostUser;
use common\models\KeyTipFisierDosarTipCategorie;
use common\models\NomTipFisierDosar;
use common\models\search\DocumnteUserSearch;
use common\models\User;
use kartik\dialog\Dialog;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\View;
/**
 * DocumenteUserController implements the CRUD actions for DocumenteUser model.

 */
class DocumenteUserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all DocumenteUser models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocumnteUserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumenteUser model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionPartial($id_post){

        $model=new DocumenteUser();
        $document=[];
        $fisiere_existente=NomTipFisierDosar::find()
            ->innerJoin(['c'=>CandidatFisier::tableName()],'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_user_adaugare'=>Yii::$app->user->identity->id])
            ->asArray()->all();
        $fisiere_necesare=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
            ->where(['kk.id_post_vacant'=>$id_post])
            ->asArray()->all();
        $fisiere_form=array();
        foreach ($fisiere_necesare as $fn) {
            foreach ($fisiere_existente as $fe) {
                if($fn['id']==$fe['id'] && $fn['nume']==$fe['nume']){
                    array_push($fisiere_form,$fn);
                }
            }
        }

        foreach($fisiere_form as $tf){
            $document[]=new NomTipFisierDosar();
        }
        if (Model::loadMultiple($document,Yii::$app->request->post())&& Model::validateMultiple($document)) {
            $rezultate=array();
//            echo '<pre>';
//            print_r($rezultate);
//            echo '</pre>';
//            die();
            for($i=0;$i<count($fisiere_form);$i++)
            {
                if($document[$i]['nume']==1)
                {
                    array_push($rezultate,$fisiere_form[$i]);
                }
            }

            $var=0;
            for ($i = 0; $i < count($fisiere_necesare); $i++) {
                for ($j = 0; $j < count($fisiere_form); $j++) {
                    if($fisiere_necesare[$i]['id']==$fisiere_form[$j]['id'] && $fisiere_necesare[$i]['nume']==$fisiere_form[$j]['nume'])
                        $var=1;
                }
                if($var==0) {
                    array_push($rezultate, $fisiere_necesare[$i]);
                }
                $var=0;
            }
            if(empty($rezultate)){
                $inscriere=new KeyInscrierePostUser();
                $inscriere->id_post=$id_post;
                $inscriere->id_user=Yii::$app->user->identity->id;
                $inscriere->save();
                Yii::$app->response->redirect(['/anunt/index']);
            }
            else{
                Yii::$app->response->redirect(['/documente-user/create', 'id_post' => $id_post, 'fisiere' => $rezultate]);
            }
        }
        for($i=0;$i<count($fisiere_form);$i++) {
            $document[$i]->nume = $fisiere_form[$i]['nume'];
            $document[$i]->id = $fisiere_form[$i]['id'];
        }

        return $this->render('partial',[
            'model'=>$model,
            'document'=>$document,
        ]);
    }


    public function actionSamedoc($id_post){

        $fisiere_necesare=NomTipFisierDosar::find()
            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
            ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
            ->where(['kk.id_post_vacant'=>$id_post])
            ->asArray()->all();
        $fisere_existente=NomTipFisierDosar::find()
            ->innerJoin(['c'=>CandidatFisier::tableName()],'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_user_adaugare'=>Yii::$app->user->identity->id])
            ->asArray()->all();

        $rezultate=array();

        $var=0;
        for ($i = 0; $i < count($fisiere_necesare); $i++) {
            for ($j = 0; $j < count($fisere_existente); $j++) {
                if($fisiere_necesare[$i]['id']==$fisere_existente[$j]['id'] && $fisiere_necesare[$i]['nume']==$fisere_existente[$j]['nume'])
                    $var=1;
            }
            if($var==0) {
                    array_push($rezultate, $fisiere_necesare[$i]);
            }
            $var=0;
        }
        if(empty($rezultate)) {
            $inscriere=new KeyInscrierePostUser();
            $inscriere->id_post=$id_post;
            $inscriere->id_user=Yii::$app->user->identity->id;
            $inscriere->data_inscriere=date('Y-m-d H:i:s');
            $inscriere->save();
            Yii::$app->response->redirect(['/anunt/index']);
        }
        else {
            Yii::$app->response->redirect(['/documente-user/create', 'id_post' => $id_post, 'fisiere' => $rezultate]);
        }
    }

    public function actionActualizeazadoc(){
        $tip_fisier = Yii::$app->request->get('tip_fisier');
        $tip_fisier_array=[$tip_fisier];
        Yii::$app->response->redirect(['/documente-user/create', 'id_post' => -1, 'fisiere' => $tip_fisier_array]);
    }

    public function actionInregistreazadoc(){
        $model=new DocumenteUser();
        $documente=[];
        $fisiere=NomTipFisierDosar::find()->asArray()->all();
        foreach ($fisiere as $f)
            $documente[]=new NomTipFisierDosar();

        if(Model::loadMultiple($documente,Yii::$app->request->post())&& Model::validateMultiple($documente)){
            $rezultate=array();
            for($i=0;$i<count($fisiere);$i++)
            {
                if($documente[$i]['nume']==1)
                {
                    array_push($rezultate,$fisiere[$i]);
                }
            }

            Yii::$app->response->redirect(['/documente-user/create', 'id_post' => -1, 'fisiere' => $rezultate]);
        }
        for($i=0;$i<count($fisiere);$i++) {
            $documente[$i]->nume = $fisiere[$i]['nume'];
            $documente[$i]->id = $fisiere[$i]['id'];
        }


        return $this->render('inregistreazadoc',[
            'model'=>$model,
            'documente'=>$documente,
        ]);


    }
    public function actionActualizeazatot(){
        $model=new DocumenteUser();
        $documente=[];

        $fisiere_existente=NomTipFisierDosar::find()
            ->innerJoin(['c'=>CandidatFisier::tableName()],'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_user_adaugare'=>Yii::$app->user->identity->id])
            ->asArray()->all();
        $toate_fisierele=NomTipFisierDosar::find()->asArray()->all();
        $fisier_existent=0;
        $restul_fisierelor=array();
        foreach ($toate_fisierele as $tf) {
            foreach ($fisiere_existente as $fe) {
                if($tf['id']==$fe['id'] && $tf['nume']==$fe['nume'])
                    $fisier_existent=1;
            }
            if($fisier_existent==0)
                array_push($restul_fisierelor,$tf);
            else
                $fisier_existent=0;

        }

        $total_fisier=array();
        foreach ($fisiere_existente as $fe)
            array_push($total_fisier,$fe);
        foreach ($restul_fisierelor as $rf)
            array_push($total_fisier,$rf);


        foreach($toate_fisierele as $tf){
            $documente[]=new NomTipFisierDosar();
        }

        if (Model::loadMultiple($documente,Yii::$app->request->post())&& Model::validateMultiple($documente)) {
           $rezultate=array();

            for($i=0;$i<count($toate_fisierele);$i++)
            {
                if($documente[$i]['nume']==1)
                {
                    array_push($rezultate,$total_fisier[$i]);
                }
            }


            Yii::$app->response->redirect(['/documente-user/create', 'id_post' => -1, 'fisiere' => $rezultate]);
        }



        for($i=0;$i<count($total_fisier);$i++) {
            $documente[$i]->nume = $total_fisier[$i]['nume'];
            $documente[$i]->id = $total_fisier[$i]['id'];
        }
        $nr_existente=count($fisiere_existente);


        return $this->render('actualizeazatot',[
            'model'=>$model,
            'documente'=>$documente,
            'nr_existente'=>$nr_existente,

        ]);
    }

    /**
     * Creates a new DocumenteUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $tip_fisier = Yii::$app->request->get('fisiere');
        $id_post=Yii::$app->request->get('id_post');
        $model = new DocumenteUser();
        $rez=false;
        Yii::$app->params['bsDependencyEnabled'] = false;
        echo Dialog::widget([
            'libName' => 'krajeeDialogInscriere',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => 'Inscriere post',
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
        echo Dialog::widget([
            'libName' => 'krajeeDialogIncarcare',
            'dialogDefaults' => [
                Dialog::DIALOG_OTHER => [
                    'buttons' => ''
                ]
            ] ,
            'options' => [
                'size' => Dialog::SIZE_MEDIUM,
                'type' => Dialog::TYPE_SUCCESS,
                'title' => 'Documente incarcate',
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

        $document=[];
        if(!is_null($tip_fisier))
            foreach($tip_fisier as $tf){
                $document[]=new CandidatFisier();
            }
        else{
            Yii::$app->response->redirect(['/candidat-fisier/index']);
        }
        $id_user=Yii::$app->user->identity->id;
        if(Model::loadMultiple($document,Yii::$app->request->post())&& Model::validateMultiple($document)) {

            $nume_utilizator= User::find()->where(['id'=>Yii::$app->user->identity->id])->asArray()->all()[0]["username"];
            for($i=0;$i<count($_FILES["CandidatFisier"]["name"]);$i++) {
                $sters=0;
                $old_doc=CandidatFisier::find()
                    ->where(['id_nom_tip_fisier_dosar'=>$_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"]])
                    ->all();

                for ($j = 0; $j < count($_FILES["CandidatFisier"]["name"][$i]["fisiere"]); $j++) {

                    if (strlen($_FILES["CandidatFisier"]["name"][$i]["fisiere"][$j]) > 3) {
                        $doc = new CandidatFisier();
                        $extensie = explode("/", $_FILES["CandidatFisier"]["type"][$i]["fisiere"][$j]);
                        $nume_document = NomTipFisierDosar::find()->where(['id' => $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"]])->asArray()->all()[0]["nume"];
                        $nume_document = preg_replace('/\s+/', '_', $nume_document);
                        $doc->nume_fisier_afisare = $_FILES["CandidatFisier"]["name"][$i]["fisiere"][$j];
                        $doc->cale_fisier = "\web\storage\user_".Yii::$app->user->identity->id."\document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "(".$j.")." . $extensie[1];
                        $doc->data_adaugare = date('Y-m-d H:i:s');
                        $doc->descriere = "descriere";
                        $doc->id_user_adaugare = Yii::$app->user->identity->id;
                        $doc->nume_fisier_adaugare = "document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "(".$j.")." . $extensie[1];
                        $doc->id_nom_tip_fisier_dosar = $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"];
                        $doc->stare = 2;


                        if($doc->save()) {

                            if($sters==0){
                                foreach($old_doc as $od) {
                                    if(file_exists(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\" . $od->nume_fisier_adaugare)==true)
                                        unlink(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\" . $od->nume_fisier_adaugare);
                                    $od->delete();

                                }
                                $sters=1;
                            }
                            if($id_post!=-1) {
                                $exista = KeyInscrierePostUser::find()->where(['id_post' => $id_post, 'id_user' => Yii::$app->user->identity->id])->asArray()->all();
                                if (empty($exista)) {
                                    $inscriere = new KeyInscrierePostUser();
                                    $inscriere->id_post = $id_post;
                                    $inscriere->id_user = Yii::$app->user->identity->id;
                                    $inscriere->data_inscriere = date('Y-m-d H:i:s');
                                    $inscriere->save();

                                }
                            }
                        }
                        $doc->fisiere = UploadedFile::getInstances($doc, "[{$i}]fisiere[{$j}]");

                        if (!file_exists(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\")) {
                            mkdir(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\", 0777, true);
                        }
                        $doc->fisiere[0]->saveAs(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\" . $doc->nume_fisier_adaugare);
                    }
                }
            }
//            if($id_post==-1){
//                $js = <<< JS
//                krajeeDialogIncarcare.dialog(
//                "Documente incarcate cu succes",
//                function() {}
//                 );
//                JS;
//                $this->getView()->registerJs($js, View::POS_READY, '_form');
//            }
//            else{
//                $js = <<< JS
//                krajeeDialogInscriere.dialog(
//                "Inscriere realizata cu succes!",
//                function() {}
//                 );
//                JS;
//                $this->getView()->registerJs($js, View::POS_READY, '_form');
//            }
            Yii::$app->response->redirect(['/candidat-fisier/index']);

        }
        if(!is_null($tip_fisier)) {
            foreach ($tip_fisier as $key => $tf) {
                $document[$key]->id_nom_tip_fisier_dosar = $tip_fisier[$key]['id'];
            }
        }
        else{
                Yii::$app->response->redirect(['/candidat-fisier/index']);
            }
//            for($i=0;$i<count($tip_fisier);$i++){
//                $document[$i]->id_nom_tip_fisier_dosar=$tip_fisier[$i]['id'];

        return $this->render('create', [
            'model' => $model,
            'document'=>$document,
            'tip_fisier'=>$tip_fisier,
            'id_user'=>Yii::$app->user->identity->id,
        ]);
    }

    /**
     * Updates an existing DocumenteUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumenteUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionVerifica($id_post)
    {
        return $this->render('verifica', [
            'id_post'=>$id_post,
            'id_user'=>Yii::$app->user->identity->id,
        ]);
    }
    /**
     * Finds the DocumenteUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DocumenteUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumenteUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
