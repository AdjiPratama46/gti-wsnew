<?php

namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * SignupForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $password;
    public $id;
    public $authKey;
    public $accessToken;
    public $role;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            ['username', 'trim'],
            ['username' , 'email', 'message' => 'Username Harus Menggunakan Email'],
            ['name', 'trim'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z.,-]+(?:\s[a-zA-Z.,-]+)*$/',
              'message' => '{attribute} Hanya Bisa Menggunakan Huruf dan Spasi'
            ],
            ['name','role', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6, 'tooShort' => '{attribute} Setidaknya Harus Memiliki 6 Karakter'],
            [['password'], 'match', 'pattern' => '/^[A-Za-z0-9]+$/u',
              'message' => '{attribute} Hanya Bisa Menggunakan Huruf dan Angka'
            ],
            [['username'], 'required','message' => 'Username Tidak Boleh Kosong'],
            [['username'],'unique','targetClass' => '\app\models\Users','message' => 'Username Ini Sudah Digunakan'],
            [['name'], 'required','message' => 'Nama Tidak Boleh Kosong'],
            
            [['password'], 'required','message' => 'Password Tidak Boleh Kosong'],
            [['authKey','accessToken'],'string'],
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->password = $this->password;        
        Yii::$app->db->createCommand()->insert('user',
        [
            'username' => $this->username,
            'name' => $this->name,
            'password' => $this->password,
            'role' => 'user',
        ])->execute();
        $id = User::find()
        ->select(['id'])
        ->where(['username' => $this->username])
        ->asArray()
        ->one();
        
        Yii::$app->db->createCommand()->update('user',
        [
            'authKey' => 'test'.$id['id'].'key',
            'accessToken' =>  $id['id'].'-token',
        ] ,'id ='.$id['id'])->execute();

        return $user;
    }
}
