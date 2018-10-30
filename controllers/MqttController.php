<?php

namespace app\controllers;

use Yii;
use app\models\MQTTClient;
use app\models\Konfigurasi;
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

              $client = new MQTTClient('103.11.99.171', 1883);
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
      ]);
  }



  public function actionSubs(){
    $client = new MQTTClient('lumba-studio.id', 1883);
    $client->setAuthentication('','');
    $client->setEncryption('cacerts.pem');
    $success = $client->sendConnect(123);  // set your client ID
    if ($success) {
        $client->sendSubscribe('percobaan/1');
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
