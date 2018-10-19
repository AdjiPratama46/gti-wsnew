<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "konfigurasi".
 *
 * @property int $id
 * @property int $id_user
 * @property string $frekuensi
 * @property string $ip_server
 * @property string $gsm_to
 * @property string $gps_to
 * @property string $timestamp
 */
class Konfigurasi extends \yii\db\ActiveRecord
{
    public $gsm_to_h;
    public $gsm_to_m;
    public $gsm_to_s;

    public $gps_to_h;
    public $gps_to_m;
    public $gps_to_s;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'konfigurasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'frekuensi', 'ip_server', 'no_hp'], 'required'],
            [['gsm_to_h','gsm_to_m','gps_to_h','gps_to_m'], 'required'],
            [['id_user'], 'integer'],
            [['timestamp', 'gsm_to', 'gps_to'], 'safe'],
            [['frekuensi', 'ip_server', 'gsm_to', 'gps_to','no_hp'], 'string', 'max' => 255],
            ['gsm_to_m','validasiminmax1'],
            ['gps_to_m','validasiminmax2'],
        ];
    }

    public function validasiminmax1($attribute, $params){
        if ($this->$attribute=='00' && $this->gsm_to_h=='00'){
            $this->addError($attribute,'Minimal GSM Time Out adalah 5 menit');
        }
        elseif ($this->$attribute!='00' && $this->gsm_to_h=='24'){
            $this->addError($attribute,'Maksimal GSM Time Out adalah 24 jam');
        }
    }

    public function validasiminmax2($attribute, $params){
        if ($this->$attribute=='00' && $this->gps_to_h=='00'){
            $this->addError($attribute,'Minimal GPS Time Out adalah 5 menit');
        }
        elseif ($this->$attribute!='00' && $this->gps_to_h=='24'){
            $this->addError($attribute,'Maksimal GPS Time Out adalah 24 jam');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'frekuensi' => 'Frekuensi Pengiriman',
            'ip_server' => 'Ip MQTT Server',
            'gsm_to' => 'GSM Time Out',
            'gps_to' => 'GPS Time Out',
            'timestamp' => 'Timestamp',
            'no_hp' => 'Sms Server (NO. HP)',
        ];
    }

}
