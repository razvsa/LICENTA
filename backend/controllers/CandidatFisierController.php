<?php

namespace backend\controllers;

use common\models\Anunt;
use common\models\CandidatDosar;
use common\models\CandidatFisier;
use common\models\NomTipCategorie;
use common\models\NomTipFisierDosar;
use common\models\Notificare;
use common\models\PostVacant;
use common\models\search\CandidatFisierSearch;
use common\models\User;
use Elasticsearch\Endpoints\License\Post;
use Pusher\Pusher;
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
//    public function actionIndex()
//    {
//        $searchModel = new CandidatFisierSearch();
//        $dataProvider = $searchModel->search($this->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    public function actionIndex($id_dosar)
    {
        $tip_fisier=0;
        $id_user=0;
        $tip_fisier = NomTipFisierDosar::find()
            ->innerJoin(['c' => CandidatFisier::tableName()], 'c.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['c.id_candidat_dosar'=>$id_dosar])
            ->orderBy('nom_tip_fisier_dosar.id')->asArray()->all();

        return $this->render('index', [
            'tip_fisier'=>$tip_fisier,
            'id_dosar'=>$id_dosar,
        ]);
    }
    public function actionUser($status){

        $useri=new ActiveDataProvider([

            'query'=>User::find()
            ->select(['username','email','user.id'])->distinct()
            ->innerJoin(['candidat_dosar'=>CandidatDosar::tableName()],'user.id=candidat_dosar.id_user')
            ->where(['candidat_dosar.id_status'=>$status])
        ]);


        return $this->render('user',[
            'useri'=>$useri,
            'status'=>$status,
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

    public function actionPosturi($status){
        $posturi=new ActiveDataProvider([
            'query'=>PostVacant::find()
                ->innerJoin(['anunt'=>Anunt::tableName()],'post_vacant.id_anunt=anunt.id')
                ->innerJoin(['cand'=>CandidatDosar::tableName()],'post_vacant.id=cand.id_post_vacant')
                ->where(['id_status'=>$status,'anunt.id_structura'=>Yii::$app->user->getIdentity()->admin])
        ]);

        return $this->render('posturi',[
            'posturi'=>$posturi,
            'status'=>$status,
        ]);
    }

    public function actionDosare($id_post,$status){

        $dosare=new ActiveDataProvider([
            'query'=>CandidatDosar::find()
                ->where(['id_post_vacant'=>$id_post,'id_status'=>$status])
        ]);
        return $this->render('dosare',[
            'dosare'=>$dosare,
            'status'=>$status,
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


    public function actionAproba($tip_fisier,$id_dosar)
    {

        $fisiere=CandidatFisier::find()
            ->innerJoin(['nom'=>NomTipFisierDosar::tableName()],'nom.id=candidat_fisier.id_nom_tip_fisier_dosar')
            ->where(['nom.nume'=>$tip_fisier,'id_candidat_dosar'=>$id_dosar])
            ->asArray()->all();

        foreach($fisiere as $f) {
            $model = $this->findModel($f['id']);
            $model->aproba();
        }
        $verificare=CandidatFisier::find()
            ->where(['id_candidat_dosar'=>$id_dosar,'stare'=>[1,2]])
            ->asArray()->all();
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '2eb047fb81e4d1cc5937',
            '663cb0d47d32f1d742d5',
            '1603369',
            $options
        );
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $post=PostVacant::findOne(['id'=>$dosar->id_post_vacant]);

        $notificare=new Notificare();
        $notificare->continut="Documentul ".$tip_fisier." din dosarul aferent postului ".$post->denumire." a fost validat cu succes";
        $notificare->data_adaugare=date('Y-m-d H:i:s', time());
        $notificare->stare_notificare=2;
        $notificare->id_user=$dosar['id_user'];;
        $notificare->tip=1;
        $notificare->save();
        $data['message'] = '';
        $pusher->trigger('my-channel'.$notificare->id_user, 'my-event', $data);

        if(empty($verificare)==1 && $dosar->id_status!=4){

            $dosar->id_status=3;
            $dosar->save();
            $options = array(
                'cluster' => 'eu',
                'useTLS' => true
            );
            $pusher = new Pusher(
                '2eb047fb81e4d1cc5937',
                '663cb0d47d32f1d742d5',
                '1603369',
                $options
            );
            $post=PostVacant::findOne(['id'=>$dosar->id_post_vacant]);

            $notificare=new Notificare();
            $notificare->continut="DOSARUL aferent postului ".$post->denumire." a fost validat cu succes";
            $notificare->data_adaugare=date('Y-m-d H:i:s', time());
            $notificare->stare_notificare=2;
            $notificare->id_user=$dosar['id_user'];
            $notificare->tip=1;
            $notificare->save();
            $data['message'] = '';
            $pusher->trigger('my-channel'.$notificare->id_user, 'my-event', $data);

        }
        //return $this->redirect(['categorii','id_user'=>$id_user,'stare'=>$stare]);
    }
    public function actionAprobatot($id_dosar){
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $dosar->id_status=3;
        $dosar->save();
        $fisiere=CandidatFisier::find()
            ->where(['id_candidat_dosar'=>$id_dosar])->all();
        foreach($fisiere as $f){
            $f->aproba();
        }

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '2eb047fb81e4d1cc5937',
            '663cb0d47d32f1d742d5',
            '1603369',
            $options
        );
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $post=PostVacant::findOne(['id'=>$dosar->id_post_vacant]);

        $notificare=new Notificare();
        $notificare->continut="DOSARUL aferent postului ".$post->denumire." a fost validat cu succes";
        $notificare->data_adaugare=date('Y-m-d H:i:s', time());
        $notificare->stare_notificare=2;
        $notificare->id_user=$dosar['id_user'];;
        $notificare->tip=1;
        $notificare->save();
        $data['message'] = '';
        $pusher->trigger('my-channel'.$notificare->id_user, 'my-event', $data);

        return $this->redirect(['index',
            'id_dosar'=>$id_dosar
        ]);
    }



    public function actionRespinge($tip_fisier,$id_dosar)
    {
        $fisiere=CandidatFisier::find()
            ->innerJoin(['nom'=>NomTipFisierDosar::tableName()],'nom.id=candidat_fisier.id_nom_tip_fisier_dosar')
            ->where(['nom.nume'=>$tip_fisier,'id_candidat_dosar'=>$id_dosar])
            ->asArray()->all();

        foreach($fisiere as $f) {
            $model = $this->findModel($f['id']);
            $model->respinge();
        }
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        if($dosar->id_status!=2 )
        {
            $dosar->id_status=2;
            $dosar->save();
        }
//        $fisiere=CandidatFisier::find()
//            ->innerJoin(['nom'=>NomTipFisierDosar::tableName()],'nom.id=candidat_fisier.id_nom_tip_fisier_dosar')
//            ->where(['candidat_fisier.id_user_adaugare'=>$id_user,'nom.nume'=>$tip_fisier])
//            ->asArray()->all();
//
//
//        foreach($fisiere as $f) {
//            $model = $this->findModel($f['id']);
//            $model->respinge();
//            $model->delete();
//        }
//
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '2eb047fb81e4d1cc5937',
            '663cb0d47d32f1d742d5',
            '1603369',
            $options
        );
        $dosar=CandidatDosar::findOne(['id'=>$id_dosar]);
        $post=PostVacant::findOne(['id'=>$dosar->id_post_vacant]);

        $notificare=new Notificare();
        $notificare->continut="Documentul ".$tip_fisier." din dosarul aferent postului ".$post->denumire." a fost respins";
        $notificare->data_adaugare=date('Y-m-d H:i:s', time());
        $notificare->stare_notificare=2;
        $notificare->id_user=$dosar['id_user'];;
        $notificare->tip=2;
        $notificare->save();
        $data['message'] = '';
        $pusher->trigger('my-channel'.$notificare->id_user, 'my-event', $data);
//        return $this->redirect(['categorii','id_user'=>$id_user,'stare'=>$stare]);
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
    public function actionDescarcatot($id_dosar){
        $id_user=CandidatDosar::findOne(['id'=>$id_dosar])->id_user;
        $nume_utilizator=User::findOne(['id'=>$id_user])->username;
        $file = 'Documente_'.$nume_utilizator.'.zip';
        $rootfolder='Documente_'.$nume_utilizator;

        $zip = new ZipArchive();
        if ($zip->open($file, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Cannot create a zip file');
        }

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>$id_user,'id_candidat_dosar'=>$id_dosar])->asArray()->all();

        $tip_fisier=NomTipFisierDosar::find()
            ->innerJoin(['cf'=>CandidatFisier::tableName()],'cf.id_nom_tip_fisier_dosar=nom_tip_fisier_dosar.id')
            ->where(['id_user_adaugare'=>$id_user,'cf.id_candidat_dosar'=>$id_dosar])
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
    public function actionDescarcapartial($tip_fisier,$id_dosar){
        $id_user=CandidatDosar::findOne(['id'=>$id_dosar])->id_user;
        $id_tip_fisier=NomTipFisierDosar::findOne(['nume'=>$tip_fisier]);

        $documente=CandidatFisier::find()
            ->where(['id_user_adaugare'=>$id_user,'id_nom_tip_fisier_dosar'=>$id_tip_fisier['id'],'id_candidat_dosar'=>$id_dosar])->asArray()->all();

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
