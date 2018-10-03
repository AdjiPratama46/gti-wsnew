<?php
namespace app\modules\api\controllers;

use yii\rest\ActiveController;

class PerangkatApiController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\PerangkatApi';

    public function behaviors()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }
}