<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $role
 * @property string $tgl_buat
 *
 * @property Perangkat[] $perangkats
 */
class UserAPI extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password', 'authKey', 'accessToken','role'], 'required'],
            // [['name', 'username', 'password','role'], 'required'],
            [['tgl_buat'], 'safe'],
            [['name', 'username', 'password', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'role' => 'Role',
            'tgl_buat' => 'Tgl Buat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerangkats()
    {
        return $this->hasMany(Perangkat::className(), ['id_owner' => 'id']);
    }
}
