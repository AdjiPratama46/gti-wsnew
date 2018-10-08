<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Data;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

class DapiController extends ActiveController
{
    public $modelClass = 'app\models\Data';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth'],

        ];
        $behaviors['access'] = [
          'class' => AccessControl::className(),
          'rules' => [
              [
                  'allow' => true,
                  'actions' => ['data-harian'],
                  'verbs' => ['GET']
              ],
          ]

        ];
        //$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }


    public function auth($username, $password)
    {
        return \app\models\User::findlist($username,$password);
    }

    public function actionDataHarian(){
      $data=Data::find()->all();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }
}
