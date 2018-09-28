<?php

namespace app\controllers;
use Yii;
use app\models\Perangkat;
use yii\data\SqlDataProvider;

class ResumeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id_owner = Yii::$app->user->id;
        $model = Perangkat::find()
        ->where(['id_owner' => $id_owner])
        ->one();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban,
            AVG(kecepatan_angin) AS kecepatan_angin,
            (SELECT arah_angin FROM data WHERE id_perangkat="'.$model['id'].'" 
            AND MONTHNAME(tgl)=bulan GROUP BY arah_angin 
            ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
            AVG(curah_hujan) AS curah_hujan,
            AVG(temperature) AS temperature
            FROM data WHERE id_perangkat="'.$model['id'].'" GROUP BY bulan',
            
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
            
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionMinggu()
    {

        return $this->renderAjax('dataMinggu',[
            
        ]);
    }

    public function actionSearch()
    {
        $model = Perangkat::find()->one();
        return $this->render('_search',[
            'model' => $model
        ]);
    }
}
