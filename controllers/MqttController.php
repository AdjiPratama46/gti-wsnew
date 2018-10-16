<?php

namespace app\controllers;

use Yii;
use app\models\phpMQTT;
use yii\helpers\Html;
use app\models\PerangkatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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

      return $this->render('index');
  }

  public function actionPubl(){
      $server = "lumba-studio.id";     // change if necessary
      $port = 1883;                     // change if necessary
      $username = "";                   // set your username
      $password = "";                   // set your password
      $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()
      $mqtt = new phpMQTT($server, $port, $client_id);
      if ($mqtt->connect(true, NULL, $username, $password)) {
        $mqtt->publish("/cuaca/unpad/config", "Hello World! at " , 0);
        echo "success";
        $mqtt->close();
      } else {
          echo "Time out!\n";
      }
  }

  public function actionSubs(){
      $server = "lumba-studio.id";     // change if necessary
      $port = 1883;                     // change if necessary
      $username = "";                   // set your username
      $password = "";                   // set your password
      $client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()
      $mqtt = new phpMQTT($server, $port, $client_id);
      if(!$mqtt->connect(true,NULL,$username,$password)){
        exit(1);
      }

      //currently subscribed topics
      $topics['percobaan'] = array("qos"=>0, "function"=>"procmsg");
      $mqtt->subscribe($topics,0);

      while($mqtt->proc()){
      }

      $mqtt->close();
      function procmsg($topic,$msg){
        echo "Msg Recieved: $msg";
      }

  }





}
