<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    private $_status = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required', 'message' => 'Username Tidak Boleh Kosong'],
            [['password'], 'required', 'message' => 'Password Tidak Boleh Kosong'],
            ['username' , 'email', 'message' => 'Username Harus Menggunakan Email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['username', 'validateUsername'],
            ['password', 'validatePassword'],

        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $model = Users::find()->where(['username' =>$this->username])->one();
            if($model->status==0){
                  $this->addError($attribute, 'Username Yang Dimasukkan Tidak Aktif');
            }else{
              if (!$user || !$user->validateUsername($this->username)) {
                  $this->addError($attribute, 'Username Yang Dimasukkan Salah');
              }
            }

        }
    }
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $enc = sha1($this->password);
            if (!$user || !$user->validatePassword($enc)) {
                $this->addError($attribute, 'Password Yang Dimasukkan Salah');
            }
        }
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function getStatus()
    {
        if ($this->_status === false) {
            $this->_status = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
