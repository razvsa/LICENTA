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
use yii\web\UploadedFile;
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
        $rez=false;

        $tip_fisier=NomTipFisierDosar::find()->all();
        $document=[];
        foreach($tip_fisier as $tf){
            $document[]=new CandidatFisier();
        }
        if(Model::loadMultiple($document,Yii::$app->request->post())&& Model::validateMultiple($document))
        {
            $nume_utilizator= User::find()->where(['id'=>Yii::$app->user->identity->id])->asArray()->all()[0]["username"];
            for($i=0;$i<count($_FILES["CandidatFisier"]["name"]);$i++) {

                for ($j = 0; $j < count($_FILES["CandidatFisier"]["name"][$i]["fisiere"]); $j++) {

                    if (strlen($_FILES["CandidatFisier"]["name"][$i]["fisiere"][$j]) > 3) {
                        $doc = new CandidatFisier();
                        $extensie = explode("/", $_FILES["CandidatFisier"]["type"][$i]["fisiere"][$j]);
                        $nume_document = NomTipFisierDosar::find()->where(['id' => $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"]])->asArray()->all()[0]["nume"];
                        $nume_document = preg_replace('/\s+/', '_', $nume_document);
                        $doc->nume_fisier_afisare = $_FILES["CandidatFisier"]["name"][$i]["fisiere"][$j];
                        $doc->cale_fisier = "@frontend/web/storage/document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "." . $extensie[1];
                        $doc->data_adaugare = date('Y-m-d H:i:s');
                        $doc->descriere = "descriere";
                        $doc->id_user_adaugare = Yii::$app->user->identity->id;
                        $doc->nume_fisier_adaugare = "document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "(".$j.")." . $extensie[1];
                        $doc->id_nom_tip_fisier_dosar = $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"];
                        $doc->stare = 1;
                        $doc->save();
                        $doc->fisiere = UploadedFile::getInstances($doc, "[{$i}]fisiere[{$j}]");
                        $id_user=Yii::$app->user->identity->id;
                        if (!file_exists(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\")) {
                            mkdir(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\", 0777, true);
                        }
                        $doc->fisiere[0]->saveAs(\Yii::getAlias("@frontend") . "\web\storage\user_{$id_user}\\" . $doc->nume_fisier_adaugare);


                    }
                }
            }

        }
        $exista=KeyInscrierePostUser::find()->where(['id_post'=>$id_post,'id_user'=>Yii::$app->user->identity->id])->asArray()->all();
        if(empty($exista)) {
            $inscriere=new KeyInscrierePostUser();
            $inscriere->id_post=$id_post;
            $inscriere->id_user=Yii::$app->user->identity->id;
            $inscriere->save();

        }

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
