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
    public $filegambar;
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
            [['authKey','accessToken','role','gambar'],'string','max' => 255],
            [['name'], 'required','message' => 'Nama Tidak Boleh Kosong'],
            [['username'], 'required','message' => 'Username Tidak Boleh Kosong'],
            [['new_password'], 'match', 'pattern' => '/^[A-Za-z0-9]+$/u',
              'message' => '{attribute} Hanya Bisa Menggunakan Huruf dan Angka'
            ],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z.,-]+(?:\s[a-zA-Z.,-]+)*$/',
              'message' => '{attribute} Hanya Bisa Menggunakan Huruf dan Spasi'
            ],
            [['tgl_buat','status'], 'safe'],
            [['filegambar'],'file'],
            [['username'], 'match', 'pattern' => '/^([A-Za-z0-9_\.-]+)@([\dA-Za-z\.-]+)\.([A-Za-z\.]{2,6})$/',
              'message' => '{attribute} Tidak Boleh Mengandung Simbol'
            ],
            [['password'], 'required','message' => 'Password Baru Tidak Boleh Kosong'],
            [['confirm_password'], 'required','message' => 'Password Lama Tidak Boleh Kosong'],
            //[['new_password'],'required','message' => 'Password Baru Tidak Boleh Kosong'],
            ['new_password', 'string', 'min' => 6, 'tooShort' => '{attribute} Setidaknya Harus Memiliki 6 Karakter'],
            ['confirm_password', 'string', 'min' => 6, 'tooShort' => '{attribute} Setidaknya Harus Memiliki 6 Karakter'],
            // ['confirm_password', 'compare', 'compareAttribute' => 'password','message' => 'Password Tidak Sesuai'],
            // ['confirm_password','validateCP'],
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
            'gambar' => 'Gambar',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'confirm_password' => 'Password Lama',
            'new_password' => 'Password Baru',
            'role' => 'Role',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerangkats()
    {
        return $this->hasMany(Perangkat::className(), ['id_owner' => 'id']);
    }
    public function getPerangkat()
    {
        return $this->hasOne(Perangkat::className(), ['id_owner' => 'id']);
    }

}
