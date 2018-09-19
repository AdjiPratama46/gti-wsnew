<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perangkat".
 *
 * @property string $id
 * @property string $alias
 * @property int $id_owner
 * @property string $tgl_instalasi
 * @property string $longitude
 * @property string $latitude
 *
 * @property Data[] $datas
 * @property User $user
 */
class Perangkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perangkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_owner', 'tgl_instalasi', 'longitude', 'latitude'], 'required'],
            [['id_owner'], 'integer'],
            [['tgl_instalasi'], 'safe'],
            [['id', 'alias', 'longitude', 'latitude'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'id_owner' => 'Id Owner',
            'tgl_instalasi' => 'Tgl Instalasi',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::className(), ['id_perangkat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_owner']);
    }
}
