<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_vacant}}".
 *
 * @property int $id
 * @property int $id_nom_tip_functie
 * @property string $pozitie_stat_organizare
 * @property string $denumire
 * @property string $cerinte
 * @property string $data_postare
 * @property int $id_nom_judet
 * @property int $id_nom_nivel_studii
 * @property int $id_nom_nivel_cariera
 * @property string $oras
 * @property string $tematica
 * @property string $bibliografie
 *
 * @property NomJudet $nomJudet
 * @property NomNivelCariera $nomNivelCariera
 * @property NomNivelStudii $nomNivelStudii
 */
class PostVacant extends \yii\db\ActiveRecord
{
    public $id_virtual;
    /**
     * {@inheritdoc}
     */
    public $id_anunt;
    public static function tableName()
    {
        return '{{%post_vacant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nom_tip_functie', 'pozitie_stat_organizare', 'denumire', 'cerinte', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera', 'oras','tematica','bibliografie'], 'required'],
            [['id_nom_tip_functie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera'], 'integer'],
            [['pozitie_stat_organizare', 'denumire','data_postare'], 'string', 'max' => 100],
            [['cerinte','tematica','bibliografie'], 'string', 'max' => 2000],
            [['oras'], 'string', 'max' => 50],
            [['id_nom_judet'], 'exist', 'skipOnError' => true, 'targetClass' => NomJudet::class, 'targetAttribute' => ['id_nom_judet' => 'id']],
            [['id_nom_nivel_cariera'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelCariera::class, 'targetAttribute' => ['id_nom_nivel_cariera' => 'id']],
            [['id_nom_nivel_studii'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelStudii::class, 'targetAttribute' => ['id_nom_nivel_studii' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nom_tip_functie' => 'Tip Functie',
            'pozitie_stat_organizare' => 'Pozitie Stat Organizare',
            'denumire' => 'Denumire',
            'cerinte' => 'Cerinte',
            'id_nom_judet' => 'Judet',
            'id_nom_nivel_studii' => 'Nivel Studii',
            'id_nom_nivel_cariera' => 'Nivel Cariera',
            'oras' => 'Localitate',
            'data_postare'=>'Data Postare',
            'tematica'=>'Tematica',
            'bibliografie'=>'Bibliografie'
        ];
    }

    /**
     * Gets query for [[NomJudet]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomJudetQuery
     */
    public function getNomJudet()
    {
        return $this->hasOne(NomJudet::class, ['id' => 'id_nom_judet']);
    }

    /**
     * Gets query for [[NomNivelCariera]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomNivelCarieraQuery
     */
    public function getNomNivelCariera()
    {
        return $this->hasOne(NomNivelCariera::class, ['id' => 'id_nom_nivel_cariera']);
    }

    /**
     * Gets query for [[NomNivelStudii]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\NomNivelStudiiQuery
     */
    public function getNomNivelStudii()
    {
        return $this->hasOne(NomNivelStudii::class, ['id' => 'id_nom_nivel_studii']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostVacantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostVacantQuery(get_called_class());
    }

    public function getDataConcurs(){
        $anunt=Anunt::find()
            ->innerJoin(['kap'=>KeyAnuntPostVacant::tableName()],'kap.id_anunt=anunt.id')
            ->innerJoin(['p'=>PostVacant::tableName()],'p.id=kap.id_post_vacant')
            ->where(['p.id'=>$this->id])->asArray()->all();
        return $anunt[0]['data_concurs'];
    }

    public function getInscriereConcurs(){
                $anunt=Anunt::find()
            ->innerJoin(['kap'=>KeyAnuntPostVacant::tableName()],'kap.id_anunt=anunt.id')
            ->innerJoin(['p'=>PostVacant::tableName()],'p.id=kap.id_post_vacant')
            ->where(['p.id'=>$this->id])->asArray()->all();
        return $anunt[0]['data_limita_inscriere_concurs'];
    }
    public function getLocalitate(){
        $localitate=NomLocalitate::findOne(['id'=>$this->oras]);
        return $localitate['nume'];
    }

    public function getJudet(){
        $localitate=NomLocalitate::findOne(['id'=>$this->oras]);
        return $localitate['judet'];
    }
    public function getCariera(){
        $cariera=NomNivelCariera::findOne(['id'=>$this->id_nom_nivel_cariera]);
        return $cariera['nume'];
    }
    public function getStudii(){
        $cariera=NomNivelStudii::findOne(['id'=>$this->id_nom_nivel_studii]);
        return $cariera['nume'];
    }
    public function getFunctie(){
        $functie=NomTipIncadrare::findOne(['id'=>$this->id_nom_tip_functie]);
        return $functie['nume'];
    }
    public function getDepartament(){
        $departament=NomDepartament::find()
            ->innerJoin(['a'=>Anunt::tableName()],'a.departament= nom_departament.id')
            ->innerJoin(['kap'=>KeyAnuntPostVacant::tableName()],'kap.id_anunt=a.id')
            ->innerJoin(['p'=>PostVacant::tableName()],'p.id=kap.id_post_vacant')
            ->where(['p.id'=>$this->id])->asArray()->all();

        return $departament[0]['nume'];
    }
    public function getIdAnunt(){
        $key=KeyAnuntPostVacant::findOne(['id_post_vacant'=>$this->id]);
        return $key['id_anunt'];
    }
    public function getIdStructura(){
        $anunt=Anunt::find()
        ->innerJoin(['k'=>KeyAnuntPostVacant::tableName()],'k.id_anunt=anunt.id')
        ->where(['k.id_post_vacant'=>$this->id])->one();
        return $anunt['id_structura'];
    }



}
