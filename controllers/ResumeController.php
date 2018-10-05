<?php

namespace app\controllers;
use Yii;
use app\models\Perangkat;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
class ResumeController extends \yii\web\Controller
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
            FROM data WHERE id_perangkat="'.$model['id'].'" GROUP BY bulan ORDER BY MONTH(tgl) ASC',

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

    public function actionMinggu($bulan)
    {
        $id_owner = Yii::$app->user->id;
        $model = Perangkat::find()
        ->where(['id_owner' => $id_owner])
        ->one();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT WEEK(tgl) as minggu,AVG(kelembaban) as kelembaban,
            AVG(kecepatan_angin) as kecepatan_angin,
            (SELECT arah_angin from data where id_perangkat="'.$model['id'].'" AND WEEK(tgl)=minggu GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) as arah_angin,
            AVG(curah_hujan) as curah_hujan,
            AVG(temperature) as temperature
            from data
            where id_perangkat="'.$model['id'].'" AND MONTHNAME(tgl)="'.$bulan.'"
            group by minggu',
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('dataMinggu',[
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionBulan($tahun)
    {
        $id_owner = Yii::$app->user->id;
        $model = Perangkat::find()
        ->where(['id_owner' => $id_owner])
        ->one();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT WEEK(tgl) as minggu,AVG(kelembaban) as kelembaban,
            AVG(kecepatan_angin) as kecepatan_angin,
            (SELECT arah_angin from data where id_perangkat="'.$model['id'].'" AND WEEK(tgl)=minggu GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) as arah_angin,
            AVG(curah_hujan) as curah_hujan,
            AVG(temperature) as temperature
            from data
            where id_perangkat="'.$model['id'].'" AND MONTHNAME(tgl)="'.$tahun.'"
            group by minggu',
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('dataBulan',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch()
    {
        $model = Perangkat::find()->one();
        return $this->render('_search',[
            'model' => $model
        ]);
    }

    public function actionGet($id)
    {
        $id_owner = Yii::$app->user->id;
        $model = Perangkat::find()
        ->where(['id_owner' => $id_owner])
        ->one();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban,
            AVG(kecepatan_angin) AS kecepatan_angin,
            (SELECT arah_angin FROM data WHERE id_perangkat="'.$id.'"
            AND MONTHNAME(tgl)=bulan GROUP BY arah_angin
            ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin,
            AVG(curah_hujan) AS curah_hujan,
            AVG(temperature) AS temperature
            FROM data WHERE id_perangkat="'.$id.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC',

            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderAjax('_index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionDate($id,$tgl)
    {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT MONTHNAME(tgl) as bulan,AVG(kelembaban) as kelembaban,
            AVG(kecepatan_angin) as kecepatan_angin,
            (SELECT arah_angin from data where id_perangkat="'.$id.'" AND MONTHNAME(tgl)=bulan GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) as arah_angin,
            AVG(curah_hujan) as curah_hujan,
            AVG(temperature) as temperature
            from data
            where id_perangkat="'.$id.'" AND YEAR(tgl)="'.$tgl.'"
            group by bulan ORDER BY MONTH(tgl) ASC',

            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderAjax('_indexthn', [
            'dataProvider' => $dataProvider,

        ]);
    }
}
