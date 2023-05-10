<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "candidat_dosar".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_post_vacant
 * @property int $id_status
 */
class CandidatDosar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidat_dosar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_post_vacant', 'id_status'], 'required'],
            [['id_user', 'id_post_vacant', 'id_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_post_vacant' => 'Id Post Vacant',
            'id_status' => 'Id Status',
        ];
    }
    public function getNumePost(){
        $post=PostVacant::findOne(['id'=>$this->id_post_vacant]);
        if($post!=null)
            return $post->denumire;
        else
            return 0;
    }


    public function getStatus(){
        $status=NomStatus::findOne(['id'=>$this->id_status]);
        if($status==null)
            return 0;
        else
            return $status->nume;
    }
}
