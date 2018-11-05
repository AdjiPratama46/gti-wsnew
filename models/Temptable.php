<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "temptable".
 *
 * @property int $id
 * @property string $id_perangkat
 * @property string $latitude
 * @property string $longitude
 * @property string $altimeter
 * @property double $temperature
 * @property double $kelembapan
 * @property double $tekanan_udara
 * @property double $kecepatan_angin
 * @property string $arah_angin
 * @property double $curah_hujan
 * @property string $timestamp
 */
class Temptable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temptable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perangkat', 'latitude', 'longitude', 'altimeter', 'temperature', 'kelembapan', 'tekanan_udara', 'kecepatan_angin', 'arah_angin', 'curah_hujan'], 'required'],
            [['temperature', 'kelembapan', 'tekanan_udara', 'kecepatan_angin', 'curah_hujan'], 'number'],
            [['timestamp','status'], 'safe'],
            [['id_perangkat', 'latitude', 'longitude', 'altimeter', 'arah_angin'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perangkat' => 'Id Perangkat',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'altimeter' => 'Altimeter',
            'temperature' => 'Temperature',
            'kelembapan' => 'Kelembapan',
            'tekanan_udara' => 'Tekanan Udara',
            'kecepatan_angin' => 'Kecepatan Angin',
            'arah_angin' => 'Arah Angin',
            'curah_hujan' => 'Curah Hujan',
            'timestamp' => 'Timestamp',
        ];
    }
}
