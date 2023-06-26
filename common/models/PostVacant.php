<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_vacant".
 *
 * @property int $id
 * @property int $id_nom_tip_functie
 * @property string $pozitie_stat_organizare
 * @property string $denumire
 * @property string $cerinte
 * @property string $tematica
 * @property string $bibliografie
 * @property int $id_nom_judet
 * @property int $id_nom_nivel_studii
 * @property int $id_nom_nivel_cariera
 * @property string $oras
 * @property string|null $data_postare
 * @property int $id_anunt
 *
 * @property Anunt $anunt
 * @property NomJudet $nomJudet
 * @property NomNivelCariera $nomNivelCariera
 * @property NomNivelStudii $nomNivelStudii
 */
class PostVacant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_vacant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nom_tip_functie', 'pozitie_stat_organizare', 'denumire', 'cerinte', 'tematica', 'bibliografie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera', 'oras', 'id_anunt'], 'required'],
            [['id_nom_tip_functie', 'id_nom_judet', 'id_nom_nivel_studii', 'id_nom_nivel_cariera', 'id_anunt'], 'integer'],
            [['cerinte', 'tematica', 'bibliografie'], 'string'],
            [['data_postare'], 'safe'],
            [['pozitie_stat_organizare'], 'string', 'max' => 100],
            [['denumire'], 'string', 'max' => 200],
            [['oras'], 'string', 'max' => 50],
            [['id_nom_judet'], 'exist', 'skipOnError' => true, 'targetClass' => NomJudet::class, 'targetAttribute' => ['id_nom_judet' => 'id']],
            [['id_nom_nivel_cariera'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelCariera::class, 'targetAttribute' => ['id_nom_nivel_cariera' => 'id']],
            [['id_nom_nivel_studii'], 'exist', 'skipOnError' => true, 'targetClass' => NomNivelStudii::class, 'targetAttribute' => ['id_nom_nivel_studii' => 'id']],
            [['id_anunt'], 'exist', 'skipOnError' => true, 'targetClass' => Anunt::class, 'targetAttribute' => ['id_anunt' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nom_tip_functie' => 'Id Nom Tip Funcție',
            'pozitie_stat_organizare' => 'Poziție Stat Organizare',
            'denumire' => 'Denumire',
            'cerinte' => 'Cerințe',
            'tematica' => 'Tematică',
            'bibliografie' => 'Bibliografie',
            'id_nom_judet' => 'Id Nom Județ',
            'id_nom_nivel_studii' => 'Id Nom Nivel Studii',
            'id_nom_nivel_cariera' => 'Id Nom Nivel Carieră',
            'oras' => 'Oraș',
            'data_postare' => 'Dată Postare',
            'id_anunt' => 'Id Anunț',
        ];
    }

    /**
     * Gets query for [[Anunt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnunt()
    {
        return $this->hasOne(Anunt::class, ['id' => 'id_anunt']);
    }


    /**
     * Gets query for [[NomJudet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomJudet()
    {
        return $this->hasOne(NomJudet::class, ['id' => 'id_nom_judet']);
    }

    /**
     * Gets query for [[NomNivelCariera]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomNivelCariera()
    {
        return $this->hasOne(NomNivelCariera::class, ['id' => 'id_nom_nivel_cariera']);
    }

    /**
     * Gets query for [[NomNivelStudii]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNomNivelStudii()
    {
        return $this->hasOne(NomNivelStudii::class, ['id' => 'id_nom_nivel_studii']);
    }
    public function getDataConcurs(){
        $anunt=Anunt::find()
            ->innerJoin(['p'=>PostVacant::tableName()],'anunt.id=p.id_anunt')
            ->where(['p.id'=>$this->id])->asArray()->all();
        return $anunt[0]['data_concurs'];
    }

    public function getInscriereConcurs(){
        $anunt=Anunt::find()
            ->innerJoin(['p'=>PostVacant::tableName()],'p.id_anunt=anunt.id')
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
    public function getStructura(){
        $structura=NomStructura::find()
            ->innerJoin(['a'=>Anunt::tableName()],'a.id_structura= nom_structura.id')
            ->innerJoin(['p'=>PostVacant::tableName()],'p.id_anunt=a.id')
            ->where(['p.id'=>$this->id])->asArray()->all();

        return $structura[0]['nume'];
    }
    public function getIdStructura(){
        $anunt=Anunt::find()
            ->where(['id'=>$this->id_anunt])->one();
        return $anunt['id_structura'];
    }
    public function getDataLimitaInscriere(){
        $data=Anunt::find()
            ->select(['anunt.data_limita_inscriere_concurs'])
            ->innerJoin(['post'=>PostVacant::tableName()],'post.id_anunt=anunt.id')
            ->where(['post.id'=>$this->id])->asArray()->one();
        if($data)
            return $data['data_limita_inscriere_concurs'];
        else return 0;
    }
    public function estePostat(){
        $anunt=Anunt::findOne(['id'=>$this->id]);
        if($anunt==null)
            return 0;
        else{
            return $anunt->postat;
        }
    }

}
