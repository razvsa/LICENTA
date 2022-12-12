<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "documente_user".
 *
 * @property string $id
 * @property string $CV
 * @property string $diploma_bacalaureat
 * @property string $diploma_licenta
 * @property string $diploma_master
 * @property string $act_identitate
 * @property string $carnet_munca
 * @property string $adeaverinta_vechime_munca
 * @property string $livret_militar
 * @property string $certificat_nastere
 * @property string $certificat_casatorie
 * @property string $certificat_nastere_partener
 * @property string $certificat_nastere_copii
 * @property string $autobiografie
 * @property string $tabel_nominal_rude
 * @property string $cazier
 * @property string $fotografie
 * @property string $adeverinta_medic_familie
 * @property string $consintamant_informat
 * @property string $aviz_psihologic
 * @property string $declaratie_de_conformitate
 */
class DocumenteUser extends \yii\db\ActiveRecord
{
    public int $id_post;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documente_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CV', 'diploma_bacalaureat', 'diploma_licenta', 'diploma_master', 'act_identitate', 'carnet_munca', 'adeaverinta_vechime_munca', 'livret_militar', 'certificat_nastere', 'certificat_casatorie', 'certificat_nastere_partener', 'certificat_nastere_copii', 'autobiografie', 'tabel_nominal_rude', 'cazier', 'fotografie', 'adeverinta_medic_familie', 'consintamant_informat', 'aviz_psihologic', 'declaratie_de_conformitate'], 'required'],
            [['CV', 'diploma_bacalaureat', 'diploma_licenta', 'diploma_master', 'act_identitate', 'carnet_munca', 'adeaverinta_vechime_munca', 'livret_militar', 'certificat_nastere', 'certificat_casatorie', 'certificat_nastere_partener', 'certificat_nastere_copii', 'autobiografie', 'tabel_nominal_rude', 'cazier', 'fotografie', 'adeverinta_medic_familie', 'consintamant_informat', 'aviz_psihologic', 'declaratie_de_conformitate'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'CV' => 'Cv',
            'diploma_bacalaureat' => 'Diploma Bacalaureat',
            'diploma_licenta' => 'Diploma Licenta',
            'diploma_master' => 'Diploma Master',
            'act_identitate' => 'Act Identitate',
            'carnet_munca' => 'Carnet Munca',
            'adeaverinta_vechime_munca' => 'Adeaverinta Vechime Munca',
            'livret_militar' => 'Livret Militar',
            'certificat_nastere' => 'Certificat Nastere',
            'certificat_casatorie' => 'Certificat Casatorie',
            'certificat_nastere_partener' => 'Certificat Nastere Partener',
            'certificat_nastere_copii' => 'Certificat Nastere Copii',
            'autobiografie' => 'Autobiografie',
            'tabel_nominal_rude' => 'Tabel Nominal Rude',
            'cazier' => 'Cazier',
            'fotografie' => 'Fotografie',
            'adeverinta_medic_familie' => 'Adeverinta Medic Familie',
            'consintamant_informat' => 'Consintamant Informat',
            'aviz_psihologic' => 'Aviz Psihologic',
            'declaratie_de_conformitate' => 'Declaratie De Conformitate',
        ];
    }

}
