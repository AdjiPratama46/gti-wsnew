<?php

namespace app\controllers;

use Yii;
use app\models\MQTTClient;
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

  public function actionSub($symbol = 'global')
    {
        //Check offline msg demo
        $msg = $this->server->redis->get('mqtt_notice_offline_@' . $symbol);
        return $this->publish([$this->fd], $this->topic, $msg);
    }

  public function actionIndex()
  {

      return $this->render('index');
  }

  public function actionPubl(){
      $client = new MQTTClient('lumba-studio.id', 1883);
      $client->setAuthentication('','');
      $client->setEncryption('cacerts.pem');
      $success = $client->sendConnect(123456);  // set your client ID
      if ($success) {
          $sc=$client->sendPublish('percobaan', 'mantap', 1);
          if($sc){
            echo "mantap";
          }
          $client->sendDisconnect();
      }
      $client->close();
  }

  public function actionSubs(){
    $client = new MQTTClient('lumba-studio.id', 1883);
    $client->setAuthentication('','');
    $client->setEncryption('cacerts.pem');
    $success = $client->sendConnect(123456);  // set your client ID
    if ($success) {
        $client->sendSubscribe('percobaan');
        $messages = $client->getPublishMessages();  // now read and acknowledge all messages waiting
        foreach ($messages as $message) {
            echo $message['topic'] .': '. $message['message'] . PHP_EOL;
        }
        $client->sendDisconnect();
    }
    $client->close();


  }






}
