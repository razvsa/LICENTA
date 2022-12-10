<?php

namespace frontend\controllers;

use common\models\DocumenteUser;
use common\models\CandidatFisier;
use common\models\KeyInscrierePostUser;
use common\models\NomTipFisierDosar;
use common\models\search\DocumnteUserSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\base\Model;
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

    /**
     * Creates a new DocumenteUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_post)
    {


        $model = new DocumenteUser();

        $tip_fisier=NomTipFisierDosar::find()->all();
        $document=[];
        foreach($tip_fisier as $tf){
            $document[]=new CandidatFisier();
        }
        if(Model::loadMultiple($document,Yii::$app->request->post())&& Model::validateMultiple($document))
        {   $rez=false;
            $nume_utilizator= User::find()->where(['id'=>Yii::$app->user->identity->id])->asArray()->all()[0]["username"];
            for($i=0;$i<count($_FILES["CandidatFisier"]["name"]);$i++) {

                for ($j = 0; $j < count($_FILES["CandidatFisier"]["name"][0]["fisiere"]); $j++) {

                    if($_FILES["CandidatFisier"]["name"][0]["fisiere"][$j]!='') {
                        $extensie = explode("/", $_FILES["CandidatFisier"]["type"][$i]["fisiere"][$j]);
                        $nume_document = NomTipFisierDosar::find()->where(['id' => $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"]])->asArray()->all()[0]["nume"];
                        $nume_document = preg_replace('/\s+/', '_', $nume_document);
                        $doc = new CandidatFisier();
                        $doc->nume_fisier_afisare = $_FILES["CandidatFisier"]["name"][0]["fisiere"][$j];
                        $doc->cale_fisier = "@frontend/web/storage/document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "." . $extensie[0];
                        $doc->data_adaugare = date('Y-m-d H:i:s');
                        $doc->descriere = "descriere";
                        $doc->id_user_adaugare = Yii::$app->user->identity->id;
                        $doc->nume_fisier_adaugare = "document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "." . $extensie[0];
                        $doc->id_nom_tip_fisier_dosar = $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"];
                        $doc->stare = 1;

                        $rez = $doc->save();
                    }
                }
            }
            if($rez==true)
            {
                $inscriere=new KeyInscrierePostUser();
                $inscriere->id_post=$id_post;
                $inscriere->id_user=Yii::$app->user->identity->id;
                $inscriere->save();

            }


           // echo '<pre>';
          //  print_r($extensie[1]);
           // print_r(count($_FILES["CandidatFisier"]["name"][0]["fisiere"]));
           // echo '</pre>';
           // die();
           // $doc=new CandidatFisier();
           // $doc->cale_fisier="@frontend/web/storage/document_".Yii::$app->user->identity->id."_".$document[0]->id_nom_tip_fisier_dosar.".".$extensie[1];
           // $doc->data_adaugare;
           // $doc->descriere="descriere";
            //$doc->id_post=$id_post;
        //   $doc->nume_fisier_afisare=;
//         //   $doc->nume_fisier_adaugare=;
     // /      $doc->id_nom_tip_fisier_dosar=;
            //$doc->stare=1;
            //$doc->save();
            //($_FILES['CandidatFisier']['name'][0]['fisiere'])


        }
//        if ($document[0]->load($this->request->post())) {
//            //CV//
//            echo '<pre>';
//            print_r($document[0]->id_nom_tip_fisier_dosar);
//            echo '</pre>';
//            die();
//            $fis->cale_fisier=$model->CV;
//            $fis->data_adaugare=date('Y-m-d H:i:s');
//            $fis->descriere="desc";
//            $fis->id_post=$id_post;
//            $fis->id_user_adaugare=Yii::$app->user->identity->id;;
//            $fis->nume_fisier_afisare="afisareCV";
//            $fis->nume_fisier_adaugare="adaugareCV";
//            $fis->save();
//            }
        foreach ($tip_fisier as $key=>$tf){
            $document[$key]->id_nom_tip_fisier_dosar=$tf->id;

        }
        return $this->render('create', [
            'model' => $model,
            'document'=>$document,
            'tip_fisier'=>$tip_fisier,
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
