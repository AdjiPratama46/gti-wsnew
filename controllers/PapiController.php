<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Perangkat;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

class PapiController extends ActiveController
{
    public $modelClass = 'app\models\Perangkat';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        $behaviors['access'] = [
          'class' => AccessControl::className(),
          'rules' => [
              [
                  'allow' => true,
                  'actions' => ['update'],
                  'verbs' => ['PUT','PATCH']
              ],

              [
                  'allow' => true,
                  'actions' => ['find-by-id','list-perangkat'],
                  'verbs' => ['GET']
              ],

              [
                  'allow' => true,
                  'actions' => ['create'],
                  'verbs' => ['POST']
              ],

              [
                  'allow' => true,
                  'actions' => ['delete'],
                  'verbs' => ['DELETE']
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

    
    public function actionCreate()
    {
        $params=$_REQUEST;
        $model = new Perangkat();
        $model->attributes=$params;

        if ($model->save()) {
      	  return array('status ' => true);
        }
        else
        {
  	       return array('status ' => false, 'data' => $model -> getErrors());
        }
    }

    public function actionUpdate($id){
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

    public function actionListPerangkat(){
      $id_owner = Yii::$app->user->id;
      $data=Perangkat::find()->where(['id_owner' => $id_owner ])->all();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

    public function actionFindById($id){
      $data=Perangkat::find()->where(['id' => $id])->one();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

    public function actionDelete($id)
    {
        $model=$this->findModel($id);

        if($model->delete())
        {
      	  return array('status'=> true, 'data'=> 'Berhasil dihapus');
        }
        else
        {
      	  return array('status'=>false, 'data'=>'Gagal dihapus');
        }

    }




}
