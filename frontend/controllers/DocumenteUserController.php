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
            Yii::$app->response->redirect(['/documente-user/create', 'id_post' => $id_post, 'fisiere' => $rezultate]);
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
            $inscriere->save();
            Yii::$app->response->redirect(['/anunt/index']);
        }
        else {
            Yii::$app->response->redirect(['/documente-user/create', 'id_post' => $id_post, 'fisiere' => $rezultate]);
        }
    }

    /**
     * Creates a new DocumenteUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $a = Yii::$app->request->get('fisiere');
        $id_post=Yii::$app->request->get('id_post');
        $model = new DocumenteUser();
        $rez=false;
        $tip_fisier=$a;
//        $tip_fisier=NomTipFisierDosar::find()
//            ->innerJoin(['k'=>KeyTipFisierDosarTipCategorie::tableName()],'k.id_tip_fisier=nom_tip_fisier_dosar.id')
//            ->innerJoin(['a'=>Anunt::tableName()],'a.categorie_fisier=k.id_categorie')
//            ->innerJoin(['kk'=>KeyAnuntPostVacant::tableName()],'kk.id_anunt=a.id')
//            ->where(['kk.id_post_vacant'=>$id_post])
//            ->asArray()->all();
//        echo '<pre>';
//        print_r($tip_fisier);
//        echo '</pre>';
//        die();
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
                        $doc->cale_fisier = "@frontend/web/storage/document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "(".$j.")." . $extensie[1];
                        $doc->data_adaugare = date('Y-m-d H:i:s');
                        $doc->descriere = "descriere";
                        $doc->id_user_adaugare = Yii::$app->user->identity->id;
                        $doc->nume_fisier_adaugare = "document_" . Yii::$app->user->identity->id . "_" . $document[$i]->id_nom_tip_fisier_dosar . "_" . $nume_utilizator . "_" . $nume_document . "(".$j.")." . $extensie[1];
                        $doc->id_nom_tip_fisier_dosar = $_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"];
                        $doc->stare = 1;

                        $old_doc=CandidatFisier::find()
                            ->where(['id_nom_tip_fisier_dosar'=>$_POST["CandidatFisier"][$i]["id_nom_tip_fisier_dosar"]])
                            ->all();

                        if($doc->save())
                        {
                            foreach($old_doc as $od)
                                $od->delete();
                            $exista=KeyInscrierePostUser::find()->where(['id_post'=>$id_post,'id_user'=>Yii::$app->user->identity->id])->asArray()->all();
                            if(empty($exista)) {
                                $inscriere=new KeyInscrierePostUser();
                                $inscriere->id_post=$id_post;
                                $inscriere->id_user=Yii::$app->user->identity->id;
                                $inscriere->save();

                            }
                        }
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

        foreach ($tip_fisier as $key=>$tf){
            $document[$key]->id_nom_tip_fisier_dosar=$tip_fisier[$key]['id'];

//            for($i=0;$i<count($tip_fisier);$i++){
//                $document[$i]->id_nom_tip_fisier_dosar=$tip_fisier[$i]['id'];
        }
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
