<?php

namespace backend\controllers;

use common\models\Anunt;
use common\models\AnuntFisier;
use common\models\NomLocalitate;
use common\models\PostFisier;
use common\models\PostVacant;
use common\models\search\AnuntSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use Yii;

/**
 * AnuntController implements the CRUD actions for Anunt model.
 */
class AnuntController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access'=>[
                    'class'=>AccessControl::class,
                    'rules'=>[
                        [
                            'allow'=>true,
                            'roles'=>['@']
                        ]
                    ]
                ],
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
     * Lists all Anunt models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AnuntSearch();
        $dataProvider = $searchModel->search_admin($this->request->queryParams);
        $localitati=(new \yii\db\Query())->select(['oras'])->from('post_vacant')->distinct()->all();
        $nivel_studii=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_studii')->distinct()->all();
        $functie=(new \yii\db\Query())->select(['id','nume'])->from('nom_tip_incadrare')->distinct()->all();
        $nivel_cariera=(new \yii\db\Query())->select(['id','nume'])->from('nom_nivel_cariera')->distinct()->all();
        if($searchModel->load(Yii::$app->request->get()))
        {
            $dataProvider = $searchModel->search_admin($this->request->queryParams);
        }
        Yii::$app->session->set('form', $this->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'localitati'=>$localitati,
            'functie'=>$functie,
            'nivel_studii'=>$nivel_studii,
            'nivel_cariera'=>$nivel_cariera,
        ]);
    }

    /**
     * Displays a single Anunt model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $anunt=Anunt::findOne(['id'=>$id]);
        if($anunt==null)
            return "Nu exista acest post";
        if($anunt->id_structura!=Yii::$app->user->getIdentity()->admin && Yii::$app->user->getIdentity()->admin!=0)
            return "Nu ai drepturi pentru acest post";
        $posturi = new ActiveDataProvider([
            //editat
            'query'=>PostVacant::find()
                ->where(['id_anunt'=>$id])]);
        $nr_posturi=$posturi->getTotalCount();
        //id 	id_anunt 	descriere 	nume_fisier_afisare 	nume_fisier_salvare 	cale_fisier 	data_adaugare 	id_user_adaugare
        $document=[];
        $document[0]=new AnuntFisier();
        $document[0]['cale_fisier']='0';
        $document[0]['nume_fisier_afisare']='0';
        $document[0]['nume_fisier_salvare']='0';
        $document[0]['descriere']='0';
        $document[0]['data_adaugare']=date('Y-m-d H:i:s');
        $document[0]['id_user_adaugare']=Yii::$app->user->id;
        $document[0]['id_anunt']=$id;
        $fisiere=new ActiveDataProvider([
            'query'=>AnuntFisier::find()->where(['id_anunt'=>$id])
        ]);

        if(Model::loadMultiple($document,Yii::$app->request->post())&& Model::validateMultiple($document)) {

            for ($i = 0; $i < count($_FILES["AnuntFisier"]["name"]); $i++) {
                for ($j = 0; $j < count($_FILES["AnuntFisier"]["name"][$i]["fisiere"]); $j++) {
                    if (strlen($_FILES["AnuntFisier"]["name"][$i]["fisiere"][$j]) > 3) {
                        $doc = new AnuntFisier();
                        if (!file_exists(\Yii::getAlias("@frontend") . "\web\storage\anunturi\anunt_{$id}\\")) {
                            mkdir(\Yii::getAlias("@frontend") . "\web\storage\anunturi\anunt_{$id}\\", 0777, true);
                        }
                        $doc->id_user_adaugare = Yii::$app->user->id;
                        $doc->data_adaugare = date('Y-m-d H:i:s');
                        $doc->id_anunt = $id;
                        $doc->nume_fisier_afisare = $_FILES["AnuntFisier"]["name"][$i]["fisiere"][$j];
                        $doc->nume_fisier_salvare='s';
                        $doc->descriere="d";
                        $index = 1;
                        while (file_exists(\Yii::getAlias("@frontend") . "\web\storage\anunturi\anunt_{$id}\\" . $doc->nume_fisier_afisare)) {
                            $info = pathinfo($_FILES["AnuntFisier"]["name"][$i]["fisiere"][$j]);
                            $filename = $info['filename'] . "(" . $index . ").";
                            $doc->nume_fisier_afisare = $filename . $info['extension'];
                            $index++;
                        }
                        $doc->cale_fisier = "\web\storage\anunturi\anunt_" . $id . "\\" . $doc->nume_fisier_afisare;
                        $doc->save();
                        $doc->fisiere = UploadedFile::getInstances($doc, "[{$i}]fisiere[{$j}]");
                        $doc->fisiere[0]->saveAs(\Yii::getAlias("@frontend") . $doc->cale_fisier);


                    }
                }
            }
      //view
            return $this->render('view', [
                'model' => $this->findModel($id),
                'posturi'=>$posturi,
                'nr_posturi'=>$nr_posturi,
                'fisiere'=>$fisiere,
                'id_anunt'=>$id,
                'document'=>$document,
            ]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'posturi'=>$posturi,
            'fisiere'=>$fisiere,
            'nr_posturi'=>$nr_posturi,
            'id_anunt'=>$id,
            'document'=>$document,
        ]);
    }

    /**
     * Creates a new Anunt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Anunt();

            if ($model->load($this->request->post())) {

                $model->id_user_adaugare=Yii::$app->user->identity->id;
                $model->data_postare=date('Y-m-d H:i:s');
                $model->postat=0;
                if(Yii::$app->user->getIdentity()->admin!=0)
                    $model->id_structura=Yii::$app->user->getIdentity()->admin;
//                echo '<pre>';
//                print_r($model->getAttributes());
//                die;
//                echo '</pre>';
                $model->save();
                return $this->redirect(['view','id'=>$model->id]);
            }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionGetLocalitate() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_judet = $parents[0];
                $out=NomLocalitate::find()->where(['id_nom_judet'=>$id_judet])->select(['id','nume as name'])->asArray()->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
    /**
     * Updates an existing Anunt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->estePostat()==1)
            return "Anunt postat,nu se pot efectua modificari";
        else {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Anunt model.
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
     * Finds the Anunt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Anunt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anunt::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionStergeAnunt($id){
        $anunt=Anunt::findOne(['id'=>$id]);
        if($anunt->estePostat()==1)
            return "Anunt postat, nu se pot efectua modificari";
        else {
            $anunt->delete();
            $posturi = PostVacant::find()->select('post_vacant.id')
                ->innerJoin(['anunt' => Anunt::tableName()], 'anunt.id=post_vacant.id_anunt')
                ->where(['anunt.id' => $id])->all();

            foreach ($posturi as $post) {
                $post->delete();
            }
            return $this->redirect(['index']);
        }
    }
    public function actionStergefisier($id,$id_anunt){
        $model=AnuntFisier::findOne(['id'=>$id]);
        $fullpath=\Yii::getAlias("@frontend") . $model->cale_fisier;
        $model->delete();
        unlink($fullpath);
        return $this->redirect(['view',
            'id'=>$id_anunt,
        ]);
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
    public function actionDescarca($id){
        $fisier=AnuntFisier::findOne(['id'=>$id]);
        $cale_completa=Yii::getAlias('@frontend').$fisier->cale_fisier;
        $this->downloadFileFaraStergere($cale_completa);
    }
    public function actionPosteazaAnunt($id){
        $model=$this->findModel($id);
        $model->postat=1;
        $model->save();
        $this->redirect(['index']);
    }
}
