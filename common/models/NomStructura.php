<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nom_structura".
 *
 * @property int $id
 * @property string $nume
 * @property string $abreviere
 * @property string $adresa
 * @property string $nr_telefon
 * @property string $email
 * @property int $apartine_de
 */
class NomStructura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nom_structura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nume', 'abreviere', 'adresa', 'nr_telefon', 'email', 'apartine_de'], 'required'],
            [['apartine_de'], 'integer'],
            [['nume'], 'string', 'max' => 100],
            [['abreviere'], 'string', 'max' => 20],
            [['adresa'], 'string', 'max' => 200],
            [['nr_telefon'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nume' => 'Nume',
            'abreviere' => 'Abreviere',
            'adresa' => 'Adresa',
            'nr_telefon' => 'Nr Telefon',
            'email' => 'Email',
            'apartine_de' => 'Apartine De',
        ];
    }
    public function getApartine(){
        if($this->apartine_de!=0) {
            $model =  NomStructura::find()->andWhere(['id' => $this->apartine_de])->asArray()->one();
            return $model['nume'];
        }
        else {
            return 0;
        }
    }
}
