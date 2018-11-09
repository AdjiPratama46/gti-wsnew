<?php

namespace app\controllers;

use Yii;
use app\models\MQTTClient;
use app\models\Konfigurasi;
use app\models\KonfigurasiSearch;
use app\models\Objconfig;
use yii\helpers\Html;
use app\models\PerangkatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use immusen\mqtt\base\BaseController;
/**
 * PerangkatController implements the CRUD actions for Perangkat model.
 */
class MqttController extends Controller
{
  public function behaviors()
  {
      return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                  'actions' => [
                      'index',
                      'view',
                      'konfig',
                  ],
                  'allow' => true,
                  'matchCallback' => function(){
                      return (Yii::$app->user->identity->role=='admin');
                  }
                ],
            ],
        ],
      ];
  }


  public function actionIndex(){
    $searchModel = new KonfigurasiSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  public function actionKonfig()
  {
      $model = new Konfigurasi();
      $mdl= Konfigurasi::find()
      ->orderBy(['timestamp' => SORT_DESC])
      ->one();

      $obj = new Objconfig();
      if ($model->load(Yii::$app->request->post())) {
        $obj->iv=intval($model->interval);
        $obj->mh=$model->ip_server;
        $obj->rn=$model->no_hp;
        $obj->gsm=intval($model->gsm_to);
        $obj->gps=intval($model->gps_to);
        $obj->code=$model->ussd_code;

        $msg = json_encode($obj);

        $obj = json_decode($msg);
        if($model->save()){

              $client = new MQTTClient('lumba-studio.id', 1883);
              $client->setAuthentication('','');
              $client->setEncryption('cacerts.pem');
              $clientID=substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);
              $success = $client->sendConnect($clientID);


              if ($success) {
                  $sc=$client->sendPublish('/cuaca/unpad/config', $msg, 0);
                  if($sc){


                    Yii::$app->getSession()->setFlash(
                        'success', 'Berhasil menyimpan data'
                    );
                  }
                  $client->sendDisconnect();
              }
              else{
                Yii::$app->getSession()->setFlash(
                    'danger', 'Gagal terhubung ke server'
                );
              }
              $client->close();


              return $this->redirect(['mqtt/konfig']);
        }
        else{
          Yii::$app->getSession()->setFlash(
              'danger', $msg
          );
        }
      }

      return $this->render('create', [
          'model' => $model,
          'mdl' => $mdl,
      ]);
  }











}
