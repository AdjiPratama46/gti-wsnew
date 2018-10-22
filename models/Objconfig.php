<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Objconfig extends Model
{
    public $iv;
    public $mh;
    public $rn;
    public $gsm;
    public $gps;
    public $code;

    public function rules()
    {
        return [
            [['iv','mh','rn','gsm','gps','code'], 'safe'],
            [['iv','gsm','gps'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'iv' => 'Interval',
            'mh' => 'MQTT Host',
            'rn' => 'Receive Number',
            'gsm' => 'GSM Time Out',
            'gps' => 'GPS Time Out',
            'code' => 'USSD Code'
        ];
    }

}
