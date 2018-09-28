<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property int $id_data
 * @property string $id_perangkat
 * @property string $tgl
 * @property double $kelembaban
 * @property double $kecepatan_angin
 * @property string $arah_angin
 * @property double $curah_hujan
 * @property double $temperature
 * @property int $kapasitas_baterai
 *
 * @property Perangkat $perangkat
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perangkat', 'kelembaban', 'kecepatan_angin', 'arah_angin', 'curah_hujan', 'temperature', 'kapasitas_baterai'], 'required'],
            [['tgl'], 'safe'],
            [['kelembaban', 'kecepatan_angin', 'curah_hujan', 'temperature'], 'number'],
            [['kapasitas_baterai'], 'integer'],
            [['id_perangkat', 'arah_angin'], 'string', 'max' => 255],
            [['id_perangkat'], 'exist', 'skipOnError' => true, 'targetClass' => Perangkat::className(), 'targetAttribute' => ['id_perangkat' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_data' => 'Id Data',
            'id_perangkat' => 'Id Perangkat',
            'tgl' => 'Pukul',
            'kelembaban' => 'Kelembapan',
            'kecepatan_angin' => 'Kecepatan Angin',
            'arah_angin' => 'Arah Angin',
            'curah_hujan' => 'Curah Hujan',
            'temperature' => 'Temperature',
            'kapasitas_baterai' => 'Kapasitas Baterai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerangkat()
    {
        return $this->hasOne(Perangkat::className(), ['id' => 'id_perangkat']);
    }
    public function getUser(){
        return $this->hasOne(Users::className(),['id' => 'id_owner'])
        ->viaTable('perangkat',['id' => 'id_perangkat']);
    }
}
