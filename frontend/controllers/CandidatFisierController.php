<?php

namespace frontend\controllers;

use common\models\CandidatDosar;
use common\models\CandidatFisier;
use common\models\KeyInscrierePostUser;
use common\models\NomTipFisierDosar;
use common\models\search\CandidatFisierSearch;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use \ZipArchive;

/**
 * CandidatFisierController implements the CRUD actions for CandidatFisier model.
 */
class CandidatFisierController extends Controller
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
     * Lists all CandidatFisier models.
     *
     * @return string
     */
    public function actionIndex($id_dosar)
    {
        $tip_fisier=0;
        $id_user=0;
        if(!Yii::$app->user->isGuest) {
            $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
            if($dosar['id_user']!=Yii::$app->user->identity->id)
                return "Acest dosar nu iti apartine";
            $tip_fisier = NomTipFisierDosar::find()
                ->innerJoin(['c' => CandidatFisier::tableName()], 'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
                ->where(['c.id_user_adaugare' => Yii::$app->user->identity->id,'c.id_candidat_dosar'=>$id_dosar])
                ->orderBy('nom_tip_fisier_dosar.id')->asArray()->all();

            $id_user = Yii::$app->user->identity->id;
        }
        return $this->render('index', [
            'tip_fisier'=>$tip_fisier,
            'id_user'=>$id_user,
            'id_dosar'=>$id_dosar,
        ]);
    }
    public function actionInvalid(){
        return $this->render('invalid');
    }

    /**
     * Displays a single CandidatFisier model.
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
     * Creates a new CandidatFisier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CandidatFisier();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CandidatFisier model.
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
     * Deletes an existing CandidatFisier model.
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

    public function descarca($path){

        if(file_exists($path)){
            return Yii::$app->response->sendFile($path);
        }
    }

    public function actionDescarca($tip,$utilizator){
        $fisiere=CandidatFisier::find()->where(['']);
    }

    /**
     * Finds the CandidatFisier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CandidatFisier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CandidatFisier::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function downloadFileFaraStergere($fullpath){
        if(!empty($fullpath)){
            header("Content-type:application/zip");
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Content-Length: ' . filesize($fullpath));
            readfile($fullpath);
            Yii::$app->end();
        }
    }
    public function downloadFile($fullpath){
        if(!empty($fullpath)){
            header("Content-type:application/zip");
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Content-Length: ' . filesize($fullpath));
            readfile($fullpath);
            unlink($fullpath);
            Yii::$app->end();
        }
    }
    public function getTipFisierbyId($id){
        return NomTipFisierDosar::findOne(['id'=>$id])->nume;
    }
    public function actionDescarcatot($id_user,$id_dosar){

        $nume_utilizator=User::findOne(['id'=>$id_user])->username;
        $file = 'Documente_'.$nume_utilizator."_dosar_".$id_dosar.'.zip';
        $rootfolder='Documente_'.$nume_utilizator."_dosar_".$id_dosar;

        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create a zip file');
        }

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>$id_user,'id_candidat_dosar'=>$id_dosar])->asArray()->all();

        $tip_fisier=NomTipFisierDosar::find()
            ->innerJoin(['cf'=>CandidatFisier::tableName()],'cf.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['cf.id_user_adaugare'=>$id_user,'cf.id_candidat_dosar'=>$id_dosar])
            ->distinct()
            ->select(['nom_tip_fisier_dosar.nume'])
            ->asArray()->all();


        $zip->addEmptyDir($rootfolder);
        foreach($tip_fisier as $tf){
            $zip->addEmptyDir($rootfolder.'\\'.$tf['nume']);
        }

        foreach($documente as $document){
            $zip->addFile(\Yii::getAlias("@frontend") .$document['cale_fisier'], $rootfolder.'\\'.$this->getTipFisierbyId($document['id_nom_tip_fisier_dosar']).'\\'.$document['nume_fisier_adaugare']);
        }

        $zip->close();
        $this->downloadFile(\Yii::getAlias('@frontend').'\web\\'.$file);
    }
    public function actionDescarcapartial($tip_fisier,$nume,$id_dosar){

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>Yii::$app->user->identity->id,'id_nom_tip_fisier_dosar'=>$tip_fisier,'id_candidat_dosar'=>$id_dosar])->asArray()->all();
        if(count($documente)==1){
//            echo '<pre>';
//            print_r(\Yii::getAlias('@frontend') .$documente[0]['cale_fisier']);
//            die;
//            echo '</pre>';
             $this->downloadFileFaraStergere(\Yii::getAlias('@frontend') .$documente[0]['cale_fisier']);
        }
        else {
            $nume_utilizator = User::findOne(['id' => Yii::$app->user->identity->id])->username;
            $file = $nume . '_' . $nume_utilizator . '.zip';
            $rootfolder = $nume . $nume_utilizator;

            $zip = new ZipArchive();
            if ($zip->open($file, ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create a zip file');
            }
            foreach ($documente as $document) {
                $zip->addFile(\Yii::getAlias("@frontend") . $document['cale_fisier'], $rootfolder . '\\' . $document['nume_fisier_adaugare']);
            }
            $zip->close();
            $this->downloadFile(\Yii::getAlias('@frontend') . '\web\\' . $file);
        }
    }

    public function actionStergedoc($tip_fisier,$id_dosar){
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        if($dosar['id_status']==3)
            return "Nu poti sterge document dintr-un dosar acceptat";
        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>Yii::$app->user->identity->id,'id_nom_tip_fisier_dosar'=>$tip_fisier,'id_candidat_dosar'=>$id_dosar])->all();
        foreach ($documente as $d){
            unlink(Yii::getAlias('@frontend').$documente[0]['cale_fisier']);
            $d->delete();
        }
        $dosar->id_status=4;
        $dosar->save();
        return $this->actionIndex($id_dosar);
    }
}
