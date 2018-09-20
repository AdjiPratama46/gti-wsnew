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


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 6, 'max' => 18, 'tooShort' => '{attribute} setidaknya harus memiliki 6 karakter'],
            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9]+$/u',
              'message' => '{attribute} hanya bisa menggunakan huruf, dan angka'
            ],
            ['name', 'trim'],
            ['name', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6, 'tooShort' => '{attribute} setidaknya harus memiliki 6 karakter'],
            [['username'], 'required','message' => 'Username Tidak Boleh Kosong'],
            [['name'], 'required','message' => 'Nama Tidak Boleh Kosong'],
            [['password'], 'required','message' => 'Password Tidak Boleh Kosong'],
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
            ])->execute();

        return $user;
    }
}
