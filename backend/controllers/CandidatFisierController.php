<?php

namespace backend\controllers;

use common\models\CandidatFisier;
use common\models\NomTipCategorie;
use common\models\NomTipFisierDosar;
use common\models\search\CandidatFisierSearch;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
    public function actionIndex()
    {
        $searchModel = new CandidatFisierSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUser($stare){

        $useri=new ActiveDataProvider([

            'query'=>User::find()
            ->select(['username','email','user.id'])->distinct()
            ->innerJoin(['candidat_fisier'=>CandidatFisier::tableName()],'user.id=candidat_fisier.id_user_adaugare')
            ->where(['candidat_fisier.stare'=>$stare])
        ]);


        return $this->render('user',[
            'useri'=>$useri,
            'stare'=>$stare,
        ]);
    }

    public function actionCategorii($id_user, $stare){

        $tip_fisier=new ActiveDataProvider([
            'query'=> $tipuri=NomTipFisierDosar::find()
            ->innerJoin(['cf'=>CandidatFisier::tableName()],'cf.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->innerJoin(['user'=>User::tableName()],'user.id=cf.id_user_adaugare')
            ->where(['user.id'=>$id_user,'cf.stare'=>$stare])
           ]);
        return $this->render('categorii',[
            'id_user'=>$id_user,
            'tip_fisier'=>$tip_fisier,
            'stare'=>$stare
            ]);

    }

    public function actionAprobate()
    {
        $searchModel = new CandidatFisierSearch();
        $dataProvider = $searchModel->search_aprobate($this->request->queryParams);

        return $this->render('aprobate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CandidatFisier model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_fisier,$id_user,$stare)
    {
        $fisiere=new ActiveDataProvider([
            'query'=>CandidatFisier::find()->where(['id_user_adaugare'=>$id_user,'id_nom_tip_fisier_dosar'=>$id_fisier])
        ]);
        $tip_fisier=NomTipFisierDosar::find()->select(['nume'])->where(['id'=>$id_fisier])->asArray()->all();
        $valid=1;
        $fis=CandidatFisier::find()->where(['id_user_adaugare'=>$id_user,'id_nom_tip_fisier_dosar'=>$id_fisier])->asArray()->all();
        foreach($fis as $f)
        {
            if($f['stare']==2)
                $valid=0;
        }

        return $this->render('view',[
            'fisiere'=>$fisiere,
            'tip_fisier'=>$tip_fisier[0]['nume'],
            'valid'=>$valid,
            'id_user'=>$id_user,
            'stare'=>$stare,
        ]);
    }

    /**
     * Creates a new CandidatFisier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */


    /**
     * Updates an existing CandidatFisier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */


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


    public function actionAproba($id_user,$tip_fisier,$stare)
    {
        $fisiere=CandidatFisier::find()
            ->innerJoin(['nom'=>NomTipFisierDosar::tableName()],'nom.id=candidat_fisier.id_nom_tip_fisier_dosar')
            ->where(['candidat_fisier.id_user_adaugare'=>$id_user,'nom.nume'=>$tip_fisier])
            ->asArray()->all();

        foreach($fisiere as $f) {
            $model = $this->findModel($f['id']);
            $model->aproba();
        }
        return $this->redirect(['categorii','id_user'=>$id_user,'stare'=>$stare]);
    }



    public function actionRespinge($id_user,$tip_fisier,$stare)
    {
        $fisiere=CandidatFisier::find()
            ->innerJoin(['nom'=>NomTipFisierDosar::tableName()],'nom.id=candidat_fisier.id_nom_tip_fisier_dosar')
            ->where(['candidat_fisier.id_user_adaugare'=>$id_user,'nom.nume'=>$tip_fisier])
            ->asArray()->all();


        foreach($fisiere as $f) {
            $model = $this->findModel($f['id']);
            $model->respinge();
            unlink(\Yii::getAlias("@frontend") . "\web\storage\user_{$model->id_user_adaugare}\\" . $model->nume_fisier_adaugare);
            $model->delete();
        }

        return $this->redirect(['categorii','id_user'=>$id_user,'stare'=>$stare]);
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
    public function actionDescarcatot($id_user){

        $nume_utilizator=User::findOne(['id'=>$id_user])->username;
        $file = 'Documente_'.$nume_utilizator.'.zip';
        $rootfolder='Documente_'.$nume_utilizator;

        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create a zip file');
        }

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>$id_user,'stare'=>3])->asArray()->all();
;
        $tip_fisier=NomTipFisierDosar::find()
            ->innerJoin(['cf'=>CandidatFisier::tableName()],'cf.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['id_user_adaugare'=>$id_user,'stare'=>3])
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
        $this->downloadFile(\Yii::getAlias('@backend').'\web\\'.$file);
    }
    public function actionDescarcapartial($tip_fisier,$id_user){

        $id_tip_fisier=NomTipFisierDosar::findOne(['nume'=>$tip_fisier]);

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>$id_user,'stare'=>3,'id_nom_tip_fisier_dosar'=>$id_tip_fisier['id']])->asArray()->all();

        if(count($documente)==1){
            $this->downloadFileFaraStergere(\Yii::getAlias('@frontend') .$documente[0]['cale_fisier']);
        }
        else {
            $nume_utilizator = User::findOne(['id' => $id_user])->username;
            $file = $tip_fisier . '_' . $nume_utilizator . '.zip';
            $rootfolder = $tip_fisier . '_' . $nume_utilizator;

            $zip = new ZipArchive();
            if ($zip->open($file, ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create a zip file');
            }
            foreach ($documente as $document) {
                $zip->addFile(\Yii::getAlias("@frontend") . $document['cale_fisier'], $rootfolder . '\\' . $document['nume_fisier_adaugare']);

            }
            $zip->close();
            $this->downloadFile(\Yii::getAlias('@backend') . '\web\\' . $file);
        }
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

}
