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

      if ($model->load(Yii::$app->request->post())) {
        $client = new MQTTClient('lumba-studio.id', 1883);
        $client->setAuthentication('','');
        $client->setEncryption('cacerts.pem');
        $success = $client->sendConnect(123456);

        $msg=$model->frekuensi.','.$model->ip_server.','.$model->no_hp.','.$model->gsm_to.','.$model->gps_to;

        if ($success) {
            $sc=$client->sendPublish('percobaan/satu', $msg, 1);
            if($sc){

              $model->save();
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

      return $this->render('create', [
          'model' => $model,
      ]);
  }



  public function actionSubs(){
    $client = new MQTTClient('lumba-studio.id', 1883);
    $client->setAuthentication('','');
    $client->setEncryption('cacerts.pem');
    $success = $client->sendConnect(12345678);  // set your client ID
    if ($success) {
        $client->sendSubscribe('percobaan/satu');
        $messages = $client->getPublishMessages();  // now read and acknowledge all messages waiting
        foreach ($messages as $message) {
            echo $message['topic'] .': '. $message['message'] . PHP_EOL;
        }
        $client->sendDisconnect();
    }
    $client->close();


  }







}
