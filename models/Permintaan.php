<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permintaan".
 *
 * @property int $id
 * @property string $id_perangkat
 * @property int $id_user
 * @property int $status
 * @property string $timestamp
 *
 * @property User $user
 */
class Permintaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permintaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perangkat', 'id_user'], 'required'],
            [['id_user', 'status'], 'integer'],
            [['timestamp'], 'safe'],
            [['id_perangkat'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
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
            'id_user' => 'Pengaju',
            'status' => 'Status',
            'timestamp' => 'Waktu Pengajuan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }
}
