<?php

namespace app\controllers;

use Yii;
use app\models\MQTTClient;
use app\models\Konfigurasi;
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
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
      ];
  }



  public function actionIndex()
  {
      $model = new Konfigurasi();
      $mdl= Konfigurasi::find()
      ->orderBy(['timestamp' => SORT_DESC])
      ->one();
      $gsmto = explode(':', $mdl->gsm_to);
      $gsmto_h=$gsmto[0];
      $gsmto_m=$gsmto[1];

      $gpsto = explode(':', $mdl->gps_to);
      $gpsto_h=$gpsto[0];
      $gpsto_m=$gpsto[1];

      if ($model->load(Yii::$app->request->post())) {
        $model->gsm_to=$model->gsm_to_h.':'.$model->gsm_to_m.':00';
        $model->gps_to=$model->gps_to_h.':'.$model->gps_to_m.':00';
        $msg=$model->frekuensi.','.$model->ip_server.','.$model->no_hp.','.$model->gsm_to.','.$model->gps_to;

        if($model->save()){
              $client = new MQTTClient('lumba-studio.id', 1883);
              $client->setAuthentication('','');
              $client->setEncryption('cacerts.pem');
              $success = $client->sendConnect(123456);


              if ($success) {
                  $sc=$client->sendPublish('percobaan/satu', $msg, 1);
                  if($sc){


                    Yii::$app->getSession()->setFlash(
                        'success', 'Berhasil menyimpan data'
                    );
                  }
                  $client->sendDisconnect();
              }
              else{
                Yii::$app->getSession()->setFlash(
                    'danger', 'Kesalahan dalam publish'
                );
              }
              $client->close();


              return $this->redirect(['mqtt/index']);
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
          'gsmto_h' => $gsmto_h,
          'gsmto_m' => $gsmto_m,
          'gpsto_h' => $gpsto_h,
          'gpsto_m' => $gpsto_m,
      ]);
  }



  public function actionSubs(){
    $client = new MQTTClient('lumba-studio.id', 1883);
    $client->setAuthentication('','');
    $client->setEncryption('cacerts.pem');
    $success = $client->sendConnect(123456789);  // set your client ID
    if ($success) {
        $client->sendSubscribe('percobaan/satu');
        $messages = $client->getPublishMessages();  // now read and acknowledge all messages waiting
        foreach ($messages as $message) {
            echo $message['topic'] .': '. $message['message'] . PHP_EOL;
            //$myArray = explode(',', $message['message']);
            //print_r ($myArray);
        }
        $client->sendDisconnect();
    }
    $client->close();


  }







}
