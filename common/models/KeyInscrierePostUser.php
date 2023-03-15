<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "key_inscriere_post_user".
 *
 * @property int $id
 * @property int $id_post
 * @property int $id_user
 * @property string $data_inscriere
 */
class KeyInscrierePostUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_inscriere_post_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_post', 'id_user','data_inscriere'], 'required'],
            [['id_post', 'id_user'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_post' => 'Id Post',
            'id_user' => 'Id User',
            'data_inscriere'=>'Data Inscriere'
        ];
    }
}
