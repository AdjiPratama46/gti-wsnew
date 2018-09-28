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
 *
 * @property Perangkat[] $perangkats
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $confirm_password;
    public $new_password;
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
            [['id'], 'integer'],
            ['username' , 'email', 'message' => 'Username Harus Menggunakan Email'],
            [['username'],'unique','targetClass' => '\app\models\Users','message' => 'Username Ini Sudah Digunakan'],
            [['authKey','accessToken'],'string'],
            [['name'], 'required','message' => 'Nama Tidak Boleh Kosong'],
            [['username'], 'required','message' => 'Username Tidak Boleh Kosong'],
            [['name','new_password'], 'match', 'pattern' => '/^[A-Za-z0-9 ]+$/u',
              'message' => '{attribute} Hanya Bisa Menggunakan Huruf dan Angka'
            ],
            [['password'], 'required','message' => 'Password Baru Tidak Boleh Kosong'],
            [['confirm_password'], 'required','message' => 'Password Lama Tidak Boleh Kosong'],
            //[['new_password'],'required','message' => 'Password Baru Tidak Boleh Kosong'],
            ['new_password', 'string', 'min' => 6, 'max' => 18, 'tooShort' => '{attribute} Setidaknya Harus Memiliki 6 Karakter'],
            ['confirm_password', 'string', 'min' => 6, 'max' => 18, 'tooShort' => '{attribute} Setidaknya Harus Memiliki 6 Karakter'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password','message' => 'Password Tidak Sesuai'],
            [['name', 'username', 'password','confirm_password','authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'confirm_password' => 'Password Lama',
            'new_password' => 'Password Baru',
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
