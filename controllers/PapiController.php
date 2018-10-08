<?php
namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Perangkat;
use yii\filters\auth\HttpBasicAuth;

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
        //$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }


    public function auth($username, $password)
    {
        return \app\models\User::findlist($username,$password);
    }


    public function actionTambah()
    {
        $model = new Perangkat();
        $model -> scenario = Perangkat::SCENARIO_CREATE;
        $model -> attributes = \Yii::$app -> request -> post();
        if ($model->validate()) {
            $model->save();
            return array('status ' => true);
        }else {
            return array('status ' => false, 'data' => $model -> getErrors());
        }


    }
    



}
