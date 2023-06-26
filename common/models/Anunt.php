<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anunt".
 *
 * @property int $id
 * @property int $id_user_adaugare
 * @property string $data_postare
 * @property string $data_concurs
 * @property string $data_depunere_dosar
 * @property string $titlu
 * @property string $descriere
 * @property string|null $data_limita_inscriere_concurs
 * @property int|null $categorie_fisier
 * @property int $id_structura
 * @property int $postat
 *
 * @property AnuntFisier[] $anuntFisiers
 * @property NomTipCategorie $categorieFisier
 */
class Anunt extends \yii\db\ActiveRecord
{
    public $id_nom_judet;
    public $id_nom_tip_functie;
    public $id_nom_nivel_cariera;
    public $id_nom_nivel_studii;
    public $oras;
    public $cuvant;
    public $postare;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anunt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user_adaugare', 'data_postare', 'data_concurs', 'data_depunere_dosar', 'titlu', 'descriere', 'id_structura', 'postat'], 'required'],
            [['id_user_adaugare', 'categorie_fisier', 'id_structura', 'postat'], 'integer'],
            [['data_postare', 'data_concurs', 'data_depunere_dosar', 'data_limita_inscriere_concurs'], 'safe'],
            [['titlu'], 'string', 'max' => 100],
            [['descriere'], 'string', 'max' => 2000],
            [['categorie_fisier'], 'exist', 'skipOnError' => true, 'targetClass' => NomTipCategorie::class, 'targetAttribute' => ['categorie_fisier' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user_adaugare' => 'Id User Adăugare',
            'data_postare' => 'Dată Postare',
            'data_concurs' => 'Dată Concurs',
            'data_depunere_dosar' => 'Dată Depunere Dosar',
            'titlu' => 'Titlu',
            'descriere' => 'Descriere',
            'data_limita_inscriere_concurs' => 'Dată Limită Înscriere Concurs',
            'categorie_fisier' => 'Categorie Fișier',
            'id_structura' => 'Id Structură',
            'postat' => 'Postat',
            'id_nom_judet'=>'Județ',
            'id_nom_tip_functie'=>'Funcție',
            'id_nom_nivel_cariera'=>'Nivel Carieră',
            'id_nom_nivel_studii'=>'Nivel Studii',
            'oras'=>'Oraș'
        ];
    }

    /**
     * Gets query for [[AnuntFisiers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnuntFisiers()
    {
        return $this->hasMany(AnuntFisier::class, ['id_anunt' => 'id']);
    }

    /**
     * Gets query for [[CategorieFisier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorieFisier()
    {
        return $this->hasOne(NomTipCategorie::class, ['id' => 'categorie_fisier']);
    }

        /**
     * Gets query for [[KeyAnuntTipIncadrares]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntTipIncadrares()
    {
        return $this->hasMany(KeyAnuntTipIncadrare::class, ['id_anunt' => 'id']);
    }

    /**
     * Gets query for [[KeyAnuntProbaConcurs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntProbaConcurs()
    {
        return $this->hasMany(KeyAnuntProbaConcurs::class, ['id_anunt' => 'id']);
    }
    public function getNumeStructura(){
        $structura=NomStructura::find()->where(['id'=>$this->id_structura])->one();
        if($structura!=null)
            return $structura['nume'];
        else
            return 0;
    }
    public function estePostat(){
        $anunt=Anunt::findOne(['id'=>$this->id]);
        if($anunt!=null){
            return $anunt->postat;
        }
        else return -1;
    }
    public function getNumarPosturi(){
        $post=PostVacant::find()
            ->where(['id_anunt'=>$this->id])
            ->count();
        if($post!=null)
            return $post;
        else return 0;
    }
    public function getValabilitate(){
        $datetime = $this->data_limita_inscriere_concurs;
        $timestamp = strtotime($datetime);
        $currentTimestamp = time();
        if ($timestamp > $currentTimestamp) {
            return 1;
        } elseif ($timestamp < $currentTimestamp) {
            return 0;
        } else {
            return 0;
        }
    }
}
