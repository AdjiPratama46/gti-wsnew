<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\UserAPI;
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

            [
                'allow' => true,
                'actions' => ['update'],
                'verbs' => ['PUT','PATCH']
            ],

            [
                'allow' => true,
                'actions' => ['delete'],
                'verbs' => ['DELETE']
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
    
    //UPDATE USER
    public function actionUpdate(){
        $params=$_REQUEST;
        $model = $this->findModel($id);

        $model->attributes=$params;
  
        if ($model->save()) {
          return array('status ' => true);
        }
        else{
          return array('status ' => false, 'data' => $model -> getErrors());
        }
    }

    //DELETE USER
    public function actionDelete(){
        $model=$this->findModel($id);

        if($model->delete()){
      	  return array('status'=> true, 'data'=> 'Berhasil dihapus');
        }else{
      	  return array('status'=>false, 'data'=>'Gagal dihapus');
        }
    }
}
