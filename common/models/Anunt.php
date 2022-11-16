<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "anunt".
 *
 * @property int $id
 * @property int $id_user_adaugare
 * @property string $data_postare
 * @property string $data_concurs
 * @property string $data_depunere_dosar
 * @property int $id_nom_localitate
 * @property string $departament
 * @property string $cale_imagine
 *
 * @property AnuntFisier[] $anuntFisiers
 * @property KeyAnuntPostVacant[] $keyAnuntPostVacants
 * @property KeyAnuntProbaConcurs[] $keyAnuntProbaConcurs
 * @property KeyAnuntTipIncadrare[] $keyAnuntTipIncadrares
 */
class Anunt extends \yii\db\ActiveRecord
{
    public $id_nom_judet;
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
            [['id_user_adaugare', 'data_postare', 'data_concurs', 'data_depunere_dosar', 'id_nom_localitate', 'departament', 'cale_imagine'], 'required'],
            [['id_user_adaugare','id_nom_localitate','id_nom_judet'], 'integer'],
            [['data_postare', 'data_concurs', 'data_depunere_dosar'], 'safe'],
            [['departament', 'cale_imagine'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user_adaugare' => 'Id User Adaugare',
            'data_postare' => 'Data Postare',
            'data_concurs' => 'Data Concurs',
            'data_depunere_dosar' => 'Data Depunere Dosar',
            'id_nom_localitate' => 'Id Nom Localitate',
            'departament' => 'Departament',
            'cale_imagine' => 'Cale Imagine',
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
     * Gets query for [[KeyAnuntPostVacants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntPostVacants()
    {
        return $this->hasMany(KeyAnuntPostVacant::class, ['id_anunt' => 'id']);
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

    /**
     * Gets query for [[KeyAnuntTipIncadrares]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyAnuntTipIncadrares()
    {
        return $this->hasMany(KeyAnuntTipIncadrare::class, ['id_anunt' => 'id']);
    }
//    public function save($runValidation = true, $attributeNames = null)
//    {
//        $isInsert=$this->isNewRecord;
//        $saved= parent::save($runValidation, $attributeNames);
//        if(!$saved){
//            return false;
//        }
//        if($isInsert){
//            $imagePath=Yii::getAlias('@frontend/web/storage/image'.$this->id.'.png');
//            if(!is_dir(dirname($imagePath))){
//                FileHelper::createDirectory(dirname($imagePath));
//            }
//            $this->cale_imagine->saveAs($imagePath);
//        }
//        return true;
//    }
}
