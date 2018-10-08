<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Data;
use app\models\Perangkat;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;

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

              [
                  'allow' => true,
                  'actions' => ['resume'],
                  'verbs' => ['GET']
              ],
          ]

        ];
        //$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }


    public function auth($username, $password)
    {
        $userdata = \app\models\User::findlist($username,$password);
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

    public function actionResume(){
      //USER ID MASIH PAKAI USER YANG LOGIN DI WEB BUKAN DI API
      $id_owner = Yii::$app->user->id;
      $model = Perangkat::find()
      ->where(['id_owner' => $id_owner])
      ->one();

      $data = Yii::$app->db->createCommand('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban,
      AVG(kecepatan_angin) AS kecepatan_angin,
      (SELECT arah_angin FROM data WHERE id_perangkat="'.$model['id'].'"
      AND MONTHNAME(tgl)=bulan GROUP BY arah_angin
      ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
      AVG(curah_hujan) AS curah_hujan,
      AVG(temperature) AS temperature
      FROM data WHERE id_perangkat="'.$model['id'].'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')
            ->queryAll();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

}
