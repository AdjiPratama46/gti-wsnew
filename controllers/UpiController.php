<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\SignupForm;
use yii\filters\AccessControl;

class UpiController extends ActiveController
{
    public $modelClass = 'app\models\UserAPI';

    public function behaviors(){

        $behaviors = parent::behaviors();
        $behaviors['access'] = [
          'class' => AccessControl::className(),
          'rules' => [
              [
                  'allow' => true,
                  'actions' => ['create'],
                  'verbs' => ['POST']
              ],
          ]
        ];
        return $behaviors;
    }

    //MENAMBAHKAN USER
    public function actionCreate(){
        $params=$_REQUEST;
        $model = new UserAPI();
        $model->attributes=$params;

        // $time = time();
        // $enc = sha1($time);
        // $md = md5($time);
        
        
        // $pd = $params['password'];
        
        
        // $password = sha1($pd);
        // $authKey = base64_encode($enc);
        // $accessToken = sha1($md);
        
        // $model->password = $password;        
        // $model->authKey = $authKey;
        // $model->accessToken = $accessToken;
            
        if ($model->save()) {
            return array('status ' => true);
        }else{
            return array('status ' => false, 'data' => $model -> getErrors());
        }
        
        
        
        
    }

}
