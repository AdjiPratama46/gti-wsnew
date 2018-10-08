<?php

namespace app\models;

use app\models\Users;
use yii\helpers\ArrayHelper;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $name;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $role;

    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];
    private static $data;


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = Users::findOne($id);
        if (($user)) {
            return new static($user);
        }
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findlist($u,$p){
      $user = Users::find()->all();
      $data = ArrayHelper::toArray($user, [
          'app\models\Users' => [
              'id',
              'name',
              'username',
              'password',
              'authKey',
              'accessToken',
              'role',
          ],
      ]);

            foreach ($data as $user) {
                if ($user['username'] == $u AND $user['password'] == $p) {
                    return new static($user);
                }
            }

            return null;
        }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'view' or $action === 'update' or $action === 'delete')
        {
            if ( Yii::$app->user->can('supplier') === false
                 or Yii::$app->user->identity->supplierID === null
                 or $model->supplierID !== \Yii::$app->user->identity->supplierID )
            {
                 throw new \yii\web\ForbiddenHttpException('You can\'t '.$action.' this product.');
            }

        }
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = Users::find()->where(['accessToken' =>$token])->one();
        if (count($user)) {
            return new static($user);
        }

        return null;
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = Users::find()->where(['username' =>$username])->one();
        if (($user)) {
            return new static($user);
        }
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function validateUsername($username)
    {
        return $this->username === $username;
    }
}
