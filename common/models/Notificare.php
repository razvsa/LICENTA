<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notificare".
 *
 * @property int $id
 * @property string $continut
 * @property int $id_user
 * @property string $data_adaugare
 * @property int $stare_notificare
 * @property int $tip
 */
class Notificare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['continut', 'id_user', 'data_adaugare', 'stare_notificare', 'tip'], 'required'],
            [['id_user', 'stare_notificare', 'tip'], 'integer'],
            [['data_adaugare'], 'safe'],
            [['continut'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'continut' => 'Conținut',
            'id_user' => 'Id User',
            'data_adaugare' => 'Dată Adăugare',
            'stare_notificare' => 'Stare Notificare',
            'tip' => 'Tip',
        ];
    }
    public function getStareNotificare(){
        $stare=NomStareNotificare::findOne(['id'=>$this->stare_notificare]);
        if($stare!=null)
            return $stare['nume'];
        else
            return 0;
    }
}
