<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%key_anunt_post_vacant}}".
 *
 * @property int $id
 * @property int $id_anunt
 * @property int $id_post_vacant
 *
 * @property Anunt $anunt
 * @property PostVacant $postVacant
 */
class KeyAnuntPostVacant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%key_anunt_post_vacant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anunt', 'id_post_vacant'], 'required'],
            [['id_anunt', 'id_post_vacant'], 'integer'],
            [['id_anunt'], 'exist', 'skipOnError' => true, 'targetClass' => Anunt::class, 'targetAttribute' => ['id_anunt' => 'id']],
            [['id_post_vacant'], 'exist', 'skipOnError' => true, 'targetClass' => PostVacant::class, 'targetAttribute' => ['id_post_vacant' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_anunt' => 'Id Anunt',
            'id_post_vacant' => 'Id Post Vacant',
        ];
    }

    /**
     * Gets query for [[Anunt]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnuntQuery
     */
    public function getAnunt()
    {
        return $this->hasOne(Anunt::class, ['id' => 'id_anunt']);
    }

    /**
     * Gets query for [[PostVacant]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostVacantQuery
     */
    public function getPostVacant()
    {
        return $this->hasOne(PostVacant::class, ['id' => 'id_post_vacant']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\KeyAnuntPostVacantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\KeyAnuntPostVacantQuery(get_called_class());
    }
    public static function adauga($id_an,$id_post)
    {
        $mdl=new KeyAnuntPostVacant();
        $mdl->id_anunt=$id_an;
        $mdl->id_post_vacant=$id_post;
        $mdl->save();
    }
}
