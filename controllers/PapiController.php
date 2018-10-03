<?php
namespace app\controllers;

use yii\rest\ActiveController;
use app\models\Perangkat;

class PapiController extends ActiveController
{
    public $modelClass = 'app\models\Perangkat';

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