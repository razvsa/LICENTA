<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


/**
 * This is the model class for table "{{%jobs}}".
 *
 * @property int $id
 * @property string|null $Denumire
 * @property string|null $Oras
 * @property string|null $Departament
 * @property string|null $Tip
 * @property string|null $Nivel_studii
 * @property string|null $Nivel_cariera
 * @property int|null $Salariu
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * @var \yii\web\UploadedFile
     */
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jobs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Salariu'], 'integer'],
            [['Denumire', 'Oras', 'Departament', 'Tip', 'Nivel_studii', 'Nivel_cariera'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Denumire' => 'Denumire',
            'Oras' => 'Oras',
            'Departament' => 'Departament',
            'Tip' => 'Tip',
            'Nivel_studii' => 'Nivel Studii',
            'Nivel_cariera' => 'Nivel Cariera',
            'Salariu' => 'Salariu',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\JobsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\JobsQuery(get_called_class());
    }
    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert=$this->isNewRecord;
        $saved= parent::save($runValidation, $attributeNames);
        if(!$saved){
            return false;
        }
        if($isInsert){
            $videoPath=Yii::getAlias('@frontend/web/storage/image'.$this->id.'.png');
            if(!is_dir(dirname($videoPath))){
                FileHelper::createDirectory(dirname($videoPath));
            }
            $this->image->saveAs($videoPath);
        }
        return true;
    }
}
