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

    public function behaviors(){

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
                  'actions' => ['resume-bulanan'],
                  'verbs' => ['GET']
              ],

              [
                  'allow' => true,
                  'actions' => ['resume-mingguan'],
                  'verbs' => ['GET']
              ],

              [
                  'allow' => true,
                  'actions' => ['resume-bulan-by-tahun'],
                  'verbs' => ['GET']
              ],

              [
                  'allow' => true,
                  'actions' => ['resume-minggu-by-bulan'],
                  'verbs' => ['GET']
              ],
          ]

        ];
        //$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }

    public function auth($username, $password){

        return \app\models\User::findlist($username,$password);
    }

    //DATA HARIAN
    public function actionDataHarian(){
      $data=Data::find()->orderBy(['tgl' => SORT_ASC])->all();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

    //RESUME BULANAN
    public function actionResumeBulanan(){
      //BELUM MENGGUNAKAN PARAMETER TAHUN
      $id_owner = Yii::$app->user->id;
      $model = Perangkat::find()
      ->where(['id_owner' => $id_owner])
      ->one();

      $data = Yii::$app->db->createCommand('SELECT YEAR(tgl) As tahun, MONTHNAME(tgl) AS bulan,  AVG(kelembaban) AS kelembaban,
      AVG(kecepatan_angin) AS kecepatan_angin,
      (SELECT arah_angin FROM data WHERE id_perangkat="'.$model['id'].'"
      AND MONTHNAME(tgl)=bulan GROUP BY arah_angin
      ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
      AVG(curah_hujan) AS curah_hujan,
      AVG(temperature) AS temperature
      FROM data WHERE id_perangkat="'.$model['id'].'" GROUP BY bulan ORDER BY YEAR(tgl) ASC, MONTH(tgl) ASC')
            ->queryAll();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

    //RESUME MINGGUAN
    public function actionResumeMingguan(){
        //BELUM MENGGUNAKAN PARAMETER BULAN

        $id_owner = Yii::$app->user->id;

        $data = Yii::$app->db->createCommand(
          'SELECT YEAR(tgl) as tahun ,MONTHNAME(tgl) as bulan, WEEK(tgl) as minggu,
          AVG(kelembaban) as kelembaban,
          AVG(kecepatan_angin) as kecepatan_angin,
            (
              SELECT arah_angin
              from data
              where WEEK(tgl)= minggu
              GROUP BY arah_angin
              ORDER BY count(arah_angin)
              DESC LIMIT 1
            ) as arah_angin,
        AVG(curah_hujan) as curah_hujan,
        AVG(temperature) as temperature
        from data GROUP BY  Week(tgl) ORDER BY Year(tgl) ASC, Week(tgl) ASC')->queryAll();

        if(count($data)>0){
          return array('status'=>true, 'data'=>$data);
        }else{
          return array('status'=>false, 'data'=>'Tidak ada data');
        }
    }

    //RESUME DATA BULANAN BERDASARKAN TAHUN
    public function actionResumeBulanByTahun($tahun){
      $id_owner = Yii::$app->user->id;
      $model = Perangkat::find()
      ->where(['id_owner' => $id_owner])
      ->one();

      $data = Yii::$app->db->createCommand('SELECT YEAR(tgl) As tahun, MONTHNAME(tgl) AS bulan,  AVG(kelembaban) AS kelembaban,
      AVG(kecepatan_angin) AS kecepatan_angin,
      (SELECT arah_angin FROM data WHERE id_perangkat="'.$model['id'].'"
      AND MONTHNAME(tgl)=bulan GROUP BY arah_angin
      ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
      AVG(curah_hujan) AS curah_hujan,
      AVG(temperature) AS temperature
      FROM data WHERE YEAR(tgl)='.$tahun.' AND id_perangkat="'.$model['id'].'" GROUP BY bulan ORDER BY YEAR(tgl) ASC, MONTH(tgl) ASC')
            ->queryAll();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }

    //RESUME DATA MINGGUAN BERDASARKAN BULAN
    public function actionResumeMingguByBulan($bulan){
      $id_owner = Yii::$app->user->id;

      $data = Yii::$app->db->createCommand(
        'SELECT YEAR(tgl) as tahun ,MONTHNAME(tgl) as bulan, WEEK(tgl) as minggu,
        AVG(kelembaban) as kelembaban,
        AVG(kecepatan_angin) as kecepatan_angin,
          (
            SELECT arah_angin
            from data
            where WEEK(tgl)= minggu
            GROUP BY arah_angin
            ORDER BY count(arah_angin)
            DESC LIMIT 1
          ) as arah_angin,
      AVG(curah_hujan) as curah_hujan,
      AVG(temperature) as temperature
      from data WHERE MONTH(tgl)='.$bulan.' GROUP BY  Week(tgl) ORDER BY Year(tgl) ASC, Week(tgl) ASC')->queryAll();

      if(count($data)>0){
        return array('status'=>true, 'data'=>$data);
      }else{
        return array('status'=>false, 'data'=>'Tidak ada data');
      }
    }




}
