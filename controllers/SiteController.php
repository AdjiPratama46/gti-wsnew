<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\Data;
use app\models\Perangkat;
use app\models\DataSearch;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tgls=  date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
        $id_owner = Yii::$app->user->id;
        if (!Yii::$app->user->isGuest) {
          if(Yii::$app->user->identity->role=='admin'){
            $model = Perangkat::find()->innerJoinWith('datas')
            ->Where(['like', 'data.tgl', $tgls])
            ->one();
          }else{
            $model = Perangkat::find()->innerJoinWith('datas')
            ->Where(['like', 'data.tgl', $tgls])
            ->andWhere(['id_owner' => $id_owner])
            ->one();
          }

        //QUERY BOX ATAS
        $query = Yii::$app->db->createCommand
        ('SELECT id_perangkat,perangkat.alias,perangkat.latitude,perangkat.longitude,DATE(tgl)as tgl, AVG(kelembaban) AS kelembaban,
        AVG(kecepatan_angin) AS kecepatan_angin, (SELECT arah_angin FROM data WHERE id_perangkat="'.$model['id'].'" AND DATE(tgl)=DATE(NOW())-1
        GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature)
        AS temperature,AVG(tekanan_udara) AS tekanan_udara FROM data,perangkat WHERE data.id_perangkat=perangkat.id AND
        id_perangkat="'.$model['id'].'" AND DATE(tgl)=DATE(NOW())-1')
        ->queryOne();

        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $jmluser = Yii::$app->db->createCommand('SELECT count(*) as jumlah_user FROM user')->queryOne();
        $jmlperang = Yii::$app->db->createCommand('SELECT count(*) as jml FROM perangkat')->queryOne();
        $paktif = Yii::$app->db->createCommand('SELECT count(a.alias) as jumlah from perangkat, (SELECT perangkat.alias as alias FROM
        perangkat inner join data on perangkat.id=data.id_perangkat group by perangkat.alias) as a where perangkat.alias=a.alias')->queryOne();
        $dasuk = Yii::$app->db->createCommand('SELECT count(*) as jml FROM data')->queryOne();

        if (Yii::$app->user->identity->role=='user') {
                $chart = Yii::$app->db->createCommand
                ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
                SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
                perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
                AND YEAR(tgl)=YEAR(NOW()) AND data.id_perangkat="'.$model['id'].'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')
                ->queryAll();
                $pie = Yii::$app->db->createCommand
                ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
                WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
                END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
                perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND
                YEAR (tgl) = YEAR (NOW()) AND data.id_perangkat="'.$model['id'].'" GROUP BY arah_angin ORDER BY jumlah DESC')
                ->queryAll();

                $chartbulan = Yii::$app->db->createCommand
                ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
                AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
                perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND MONTH (tgl) = MONTH (NOW())
                AND data.id_perangkat="'.$model['id'].'" GROUP BY minggu ORDER BY DATE(tgl) ASC')->queryAll();
                $piebulan = Yii::$app->db->createCommand
                ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
                WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
                END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
                perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
                AND MONTH (tgl) = MONTH (NOW()) AND data.id_perangkat="'.$model['id'].'" GROUP BY arah_angin ORDER BY jumlah DESC')
                ->queryAll();

                $chartminggu = Yii::$app->db->createCommand
                ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
                THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
                kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
                AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id =
                data.id_perangkat AND user.id = "'.$id_owner.'" AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$model['id'].'"
                GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
                $pieminggu = Yii::$app->db->createCommand
                ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
                WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
                END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
                perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
                AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$model['id'].'" GROUP BY arah_angin ORDER BY jumlah DESC')
                ->queryAll();

                $charthari = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
                AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
                tekanan_udara FROM data,user,perangkat WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND 
                user.id = "'.$id_owner.'" AND id_perangkat = "'.$model['id'].'" AND DATE(tgl) = DATE(NOW()) - 1 GROUP BY waktu ORDER BY
                TIME(tgl)')->queryAll();
                $piehari = Yii::$app->db->createCommand('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" 
                WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" 
                THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user
                WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND 
                DAY(tgl) = DAY(NOW())-1 AND id_perangkat = "'.$model['id'].'" GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();
                
                $daftarhari = Yii::$app->db->createCommand
                ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN
                "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
                WHEN "Sunday" THEN "Minggu" END AS hari FROM data WHERE WEEK (tgl) = WEEK (NOW()) AND id_perangkat ="'.$model['id'].'"
                GROUP BY hari ORDER BY DATE(tgl) ASC')
                ->queryAll();

                
            return $this->render('indexuser', [
                'query' => $query,
                'model' => $model,
                'jmluser' => $jmluser,
                'paktif'=> $paktif,
                'jmlperang' => $jmlperang,
                'dasuk' => $dasuk,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'chart' => $chart,
                'pie' => $pie,
                'chartbulan' => $chartbulan,
                'piebulan' => $piebulan,
                'chartminggu' => $chartminggu,
                'pieminggu' => $pieminggu,
                'charthari' => $charthari,
                'piehari' => $piehari,
                'daftarhari' => $daftarhari
            ]);
        }else {
            $chart = Yii::$app->db->createCommand
            ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
            SUM(curah_hujan) AS curah_hujan,AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data
            WHERE YEAR (tgl) = YEAR (NOW()) GROUP BY bulan ORDER BY MONTH (tgl) ASC')->queryAll();
            $pie = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara"
            WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur"
            WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE YEAR (tgl) = YEAR (NOW())
            GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $chartbulan = Yii::$app->db->createCommand
            ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
            AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE MONTH (tgl) = MONTH (NOW())
            GROUP BY minggu ORDER BY minggu ASC')->queryAll();
            $piebulan = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE MONTH (tgl) = MONTH (NOW()) 
            GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $chartminggu = Yii::$app->db->createCommand
            ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
            WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
            WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
            SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE
            WEEK(tgl)=WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
            $pieminggu = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, 
            COUNT(arah_angin) AS jumlah FROM data WHERE WEEK(tgl)=WEEK(NOW()) GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $charthari = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
            AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
            tekanan_udara FROM data WHERE DATE(tgl) = DATE(NOW()) - 1 GROUP BY waktu ORDER BY TIME(tgl)')->queryAll();
            $piehari = Yii::$app->db->createCommand('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" 
            WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" 
            THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE DAY(tgl) = DAY(NOW())-1  
            GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            return $this->render('index', [
                'query' => $query,
                'model' => $model,
                'jmluser' => $jmluser,
                'paktif'=> $paktif,
                'jmlperang' => $jmlperang,
                'dasuk' => $dasuk,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'chart' => $chart,
                'pie' => $pie,
                'chartbulan' => $chartbulan,
                'piebulan' => $piebulan,
                'chartminggu' => $chartminggu,
                'pieminggu' => $pieminggu,
                'charthari' => $charthari,
                'piehari' => $piehari,
            ]);
        }
      }else{
        $this->layout = '//main-login';
          if (!Yii::$app->user->isGuest) {
              return $this->goHome();
          }

          $model = new LoginForm();
          if ($model->load(Yii::$app->request->post()) && $model->login()) {
              return $this->goBack();
          }
          $model->password = '';
          return $this->render('login', [
              'model' => $model,
          ]);
      }


    }

    public function actionGet($id)
    {
        $id_owner = Yii::$app->user->id;
        //QUERY BOX ATAS
        $query = Yii::$app->db->createCommand
        ('SELECT id_perangkat,perangkat.alias,perangkat.latitude,perangkat.longitude,DATE(tgl)as tgl, AVG(kelembaban) AS kelembaban,
        AVG(kecepatan_angin) AS kecepatan_angin, (SELECT arah_angin FROM data WHERE id_perangkat="'.$id.'" AND DATE(tgl)=DATE(NOW())-1
        GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature)
        AS temperature,AVG(tekanan_udara) AS tekanan_udara FROM data,perangkat WHERE data.id_perangkat=perangkat.id AND
        id_perangkat="'.$id.'" AND DATE(tgl)=DATE(NOW())-1')
        ->queryOne();

        $jmluser = Yii::$app->db->createCommand
        ('SELECT count(*) as jumlah_user FROM user')
        ->queryOne();

        $jmlperang = Yii::$app->db->createCommand
        ('SELECT count(*) as jml FROM perangkat')
        ->queryOne();

        $paktif = Yii::$app->db->createCommand
        ('SELECT count(a.alias) as jumlah from perangkat, (SELECT perangkat.alias as alias FROM perangkat inner join data on perangkat.id=data.id_perangkat group by perangkat.alias) as a where perangkat.alias=a.alias')
        ->queryOne();
        $dasuk = Yii::$app->db->createCommand
        ('SELECT count(*) as jml FROM data')
        ->queryOne();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'"',
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if (Yii::$app->user->identity->role=='user') {
            $chart = Yii::$app->db->createCommand
            ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
            SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
            perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
            AND YEAR(tgl)=YEAR(NOW()) AND data.id_perangkat="'.$id.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')
            ->queryAll();
            $pie = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
            perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND
            YEAR (tgl) = YEAR (NOW()) AND data.id_perangkat="'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')
            ->queryAll();

            $chartbulan = Yii::$app->db->createCommand
            ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
            AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
            perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND MONTH (tgl) = MONTH (NOW())
            AND data.id_perangkat="'.$id.'" GROUP BY minggu ORDER BY DATE(tgl) ASC')->queryAll();
            $piebulan = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
            perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
            AND MONTH (tgl) = MONTH (NOW()) AND data.id_perangkat="'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')
            ->queryAll();

            $chartminggu = Yii::$app->db->createCommand
            ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
            THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
            kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
            AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id =
            data.id_perangkat AND user.id = "'.$id_owner.'" AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$id.'"
            GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
            $pieminggu = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user WHERE
            perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
            AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')
            ->queryAll();

            $charthari = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
            AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
            tekanan_udara FROM data,user,perangkat WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND 
            user.id = "'.$id_owner.'" AND id_perangkat = "'.$id.'" AND DATE(tgl) = DATE(NOW()) - 1 GROUP BY waktu ORDER BY
            TIME(tgl)')->queryAll();
            $piehari = Yii::$app->db->createCommand('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" 
            WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" 
            THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user
            WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND 
            DAY(tgl) = DAY(NOW())-1 AND id_perangkat = "'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $daftarhari = Yii::$app->db->createCommand
            ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN
            "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
            WHEN "Sunday" THEN "Minggu" END AS hari FROM data WHERE WEEK (tgl) = WEEK (NOW()) AND id_perangkat ="'.$id.'"
            GROUP BY hari ORDER BY DATE(tgl) ASC')
            ->queryAll();
            return $this->renderAjax('_indexuser', [
                'query' => $query,
                'jmluser' => $jmluser,
                'paktif'=> $paktif,
                'jmlperang' => $jmlperang,
                'dasuk' => $dasuk,
                'dataProvider' => $dataProvider,
                'chart' => $chart,
                'pie' => $pie,
                'chartbulan' => $chartbulan,
                'piebulan' => $piebulan,
                'chartminggu' => $chartminggu,
                'pieminggu' => $pieminggu,
                'charthari' => $charthari,
                'piehari' => $piehari,
                'daftarhari' => $daftarhari
            ]);
        }else {
            $chart = Yii::$app->db->createCommand
            ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
            SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE
            YEAR(tgl)=YEAR(NOW()) AND id_perangkat="'.$id.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')->queryAll();
            $pie = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, 
            COUNT(arah_angin) AS jumlah FROM data WHERE YEAR (tgl) = YEAR (NOW()) AND id_perangkat="'.$id.'" GROUP BY arah_angin 
            ORDER BY jumlah DESC')->queryAll();

            $chartbulan = Yii::$app->db->createCommand
            ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
            AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE
            MONTH (tgl) = MONTH (NOW()) AND id_perangkat="'.$id.'" GROUP BY minggu ORDER BY DATE(tgl) ASC')->queryAll();
            $piebulan = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE MONTH (tgl) = MONTH (NOW()) AND id_perangkat="'.$id.'" 
            GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $chartminggu = Yii::$app->db->createCommand
            ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
            THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
            kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
            AVG(tekanan_udara) AS tekanan_udara FROM data WHERE WEEK(tgl) = WEEK(NOW()) AND id_perangkat="'.$id.'"
            GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
            $pieminggu = Yii::$app->db->createCommand
            ('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara"
            WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" THEN "Timur" WHEN "W" THEN "Barat"
            END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE WEEK(tgl)=WEEK(NOW()) AND 
            id_perangkat="'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();

            $charthari = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
            AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
            tekanan_udara FROM data WHERE id_perangkat = "'.$id.'" AND DATE(tgl) = DATE(NOW()) - 1 GROUP BY waktu ORDER BY TIME(tgl)')
            ->queryAll();
            $piehari = Yii::$app->db->createCommand('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" 
            WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" 
            THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE DAY(tgl) = DAY(NOW())-1 
            AND id_perangkat = "'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();
          

          return $this->renderAjax('_index', [
              'query' => $query,
              'jmluser' => $jmluser,
              'paktif'=> $paktif,
              'jmlperang' => $jmlperang,
              'dasuk' => $dasuk,
              'dataProvider' => $dataProvider,
              'chart' => $chart,
              'pie' => $pie,
              'chartbulan' => $chartbulan,
              'piebulan' => $piebulan,
              'chartminggu' => $chartminggu,
              'pieminggu' => $pieminggu,
              'charthari' => $charthari,
              'piehari' => $piehari,
              
          ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionChart($id,$idp,$waktu){
        $id_owner = Yii::$app->user->id;
        if ($waktu == 'tahun') {
            if ($id == 'all' && !empty($idp)) {
                if (Yii::$app->user->identity->role == 'user') {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
                    SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data,
                    perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'"
                    AND YEAR(tgl)=YEAR(NOW()) AND data.id_perangkat="'.$idp.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')->queryAll();
                }else{
                    $chart = Yii::$app->db->createCommand
                    ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
                    SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data
                    WHERE YEAR(tgl)=YEAR(NOW()) AND data.id_perangkat="'.$idp.'" GROUP BY bulan ORDER BY MONTH(tgl) ASC')->queryAll();
                }
            }elseif ($id == 'all' && empty($idp)) {
                $chart = Yii::$app->db->createCommand
                ('SELECT MONTHNAME(tgl) AS bulan, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
                SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data
                WHERE YEAR(tgl)=YEAR(NOW()) GROUP BY bulan ORDER BY MONTH(tgl) ASC')->queryAll();
            }elseif ($id == 'curah_hujan' && !empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT MONTHNAME(tgl) as bulan,SUM('.$id.') AS '.$id.'
                FROM data WHERE YEAR (tgl) = YEAR (NOW()) AND id_perangkat ="'.$idp.'" GROUP BY MONTHNAME(tgl) ORDER BY MONTH (tgl) ASC')
                ->queryAll();
            }elseif ($id == 'curah_hujan' && empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT MONTHNAME(tgl) AS bulan,SUM('.$id.') AS '.$id.'
                FROM data WHERE YEAR (tgl) = YEAR (NOW()) GROUP BY MONTHNAME(tgl) ORDER BY MONTH (tgl) ASC')
                ->queryAll();
            }elseif (!empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT MONTHNAME(tgl) as bulan,AVG('.$id.') AS '.$id.'
                FROM data WHERE YEAR (tgl) = YEAR (NOW()) AND id_perangkat ="'.$idp.'" GROUP BY MONTHNAME(tgl) ORDER BY MONTH (tgl) ASC')
                ->queryAll();
            }elseif (empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT MONTHNAME(tgl) AS bulan, AVG('.$id.') AS '.$id.' FROM data 
                WHERE YEAR (tgl) = YEAR (NOW()) GROUP BY MONTHNAME(tgl) ORDER BY MONTH (tgl) ASC')->queryAll();
            }
                return $this->renderAjax('_chart',[
                    'chart' => $chart,
                    'id' => $id,
                    'idp' => $idp,
                    'waktu' => $waktu
                ]);
        }elseif ($waktu == 'bulan') {
            if ($id == 'all' && !empty($idp)) {
                if (Yii::$app->user->identity->role == 'user') {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
                    AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
                    perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND MONTH (tgl) = MONTH (NOW())
                    AND data.id_perangkat="'.$idp.'" GROUP BY minggu ORDER BY minggu ASC')->queryAll();
                }else {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
                    AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE 
                    MONTH (tgl) = MONTH (NOW()) AND data.id_perangkat="'.$idp.'" GROUP BY minggu ORDER BY minggu ASC')->queryAll();
                }
            }elseif ($id == 'all' && empty($idp)) {
                $chart = Yii::$app->db->createCommand
                ('SELECT WEEK(tgl) AS minggu ,AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan)
                AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data WHERE 
                MONTH (tgl) = MONTH (NOW()) GROUP BY minggu ORDER BY minggu ASC')->queryAll();
            }elseif ($id == 'curah_hujan' && !empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT WEEK(tgl) as minggu,SUM('.$id.') AS '.$id.'
                FROM data WHERE MONTH (tgl) = MONTH (NOW()) AND id_perangkat ="'.$idp.'" GROUP BY minggu ORDER BY WEEK(tgl) ASC')
                ->queryAll();
            }elseif ($id == 'curah_hujan' && empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT WEEK(tgl) as minggu,SUM('.$id.') AS '.$id.'
                FROM data WHERE MONTH (tgl) = MONTH (NOW()) GROUP BY minggu ORDER BY WEEK(tgl) ASC')->queryAll();
            }elseif (!empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT WEEK(tgl) as minggu,AVG('.$id.') AS '.$id.'
                FROM data WHERE MONTH (tgl) = MONTH (NOW()) AND id_perangkat ="'.$idp.'" GROUP BY minggu ORDER BY WEEK(tgl) ASC')
                ->queryAll();
            }elseif (empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT WEEK(tgl) as minggu,AVG('.$id.') AS '.$id.'
                FROM data WHERE MONTH (tgl) = MONTH (NOW()) GROUP BY minggu ORDER BY WEEK(tgl) ASC')
                ->queryAll();
            }
                return $this->renderAjax('_chart2',[
                    'chart' => $chart,
                    'id' => $id,
                    'idp' => $idp,
                    'waktu' => $waktu
                ]);
        }elseif ($waktu == 'minggu') {
            if ($id == 'all' && !empty($idp)) {
                if (Yii::$app->user->identity->role == 'user') {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
                    THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
                    kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
                    AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id =
                    data.id_perangkat AND user.id = "'.$id_owner.'" AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$idp.'"
                    GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
                }else {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
                    THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
                    kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
                    AVG(tekanan_udara) AS tekanan_udara FROM data WHERE AND WEEK(tgl)=WEEK(NOW()) AND data.id_perangkat="'.$idp.'"
                    GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
                }
            }elseif ($id == 'all' && empty($idp)) {
                $chart = Yii::$app->db->createCommand
                ('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday"
                THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"WHEN "Sunday" THEN "Minggu" END AS hari , AVG(kelembaban) AS
                kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature,
                AVG(tekanan_udara) AS tekanan_udara FROM data WHERE WEEK(tgl)=WEEK(NOW()) GROUP BY hari 
                ORDER BY DATE(tgl) ASC')->queryAll();
            }elseif ($id == 'curah_hujan' && !empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN
                "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN
                "Sabtu" WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
                FROM data WHERE WEEK(tgl)=WEEK(NOW()) AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }elseif ($id == 'curah_hujan' && empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN
                "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN
                "Sabtu" WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
                FROM data WHERE WEEK(tgl)=WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }elseif (!empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN
                "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN
                "Sabtu" WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.' FROM data WHERE WEEK(tgl)=WEEK(NOW())
                AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }elseif (empty($idp)) {
                $chart = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN
                "Selasa" WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN
                "Sabtu" WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.' FROM data WHERE WEEK(tgl)=WEEK(NOW())
                GROUP BY hari ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }
                return $this->renderAjax('_chart3',[
                    'chart' => $chart,
                    'id' => $id,
                    'idp' => $idp,
                    'waktu' => $waktu
                ]);
        }else{
            if ($id == 'all' && !empty($waktu)) {
                if (Yii::$app->user->identity->role == 'user') {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
                    AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
                    tekanan_udara FROM data,user,perangkat WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND 
                    user.id = "'.$id_owner.'" AND id_perangkat = "'.$idp.'" AND DATE(tgl) = "'.$waktu.'" GROUP BY waktu ORDER BY
                    TIME(tgl)')->queryAll();
                }
                else {
                    $chart = Yii::$app->db->createCommand
                    ('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
                    AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
                    tekanan_udara FROM data WHERE id_perangkat = "'.$idp.'" AND DATE(tgl) = "'.$waktu.'" GROUP BY waktu ORDER BY
                    TIME(tgl)')->queryAll();
                }
            }elseif ($id == 'all' && empty($waktu)) {
                $chart = Yii::$app->db->createCommand
                ('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
                AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
                tekanan_udara FROM data,user,perangkat WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND 
                user.id = "'.$id_owner.'" AND id_perangkat = "'.$idp.'" AND DATE(tgl) = DATE(NOW()) - 1 GROUP BY waktu ORDER BY
                TIME(tgl)')->queryAll();
            }elseif ($id == 'curah_hujan' && !empty($idp) && !empty($waktu)) {
                $chart = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu,SUM('.$id.') AS '.$id.'
                FROM data WHERE DATE(tgl) = "'.$waktu.'" AND id_perangkat ="'.$idp.'" GROUP BY waktu ORDER BY TIME(tgl) ASC')
                ->queryAll();
            }elseif ($id == 'curah_hujan' && !empty($idp) && empty($waktu)) {
                $chart = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu,SUM('.$id.') AS '.$id.'
                FROM data WHERE DATE(tgl) = DATE(NOW()) - 1 AND id_perangkat ="'.$idp.'" GROUP BY waktu ORDER BY TIME(tgl) ASC')
                ->queryAll();
            }elseif (!empty($idp) && !empty($waktu)) {
                $chart = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu,AVG('.$id.') AS '.$id.' 
                FROM data WHERE DATE(tgl) = "'.$waktu.'" AND id_perangkat ="'.$idp.'" GROUP BY waktu ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }elseif (!empty($idp) && empty($waktu)){
                $chart = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu,AVG('.$id.') AS '.$id.' 
                FROM data WHERE DATE(tgl) = DATE(NOW()) - 1 AND id_perangkat ="'.$idp.'" GROUP BY waktu ORDER BY DATE(tgl) ASC')
                ->queryAll();
            }
                return $this->renderAjax('_chart4',[
                    'chart' => $chart,
                    'id' => $id,
                    'idp' => $idp,
                    'waktu' => $waktu
                ]);
        }
       

    }

    public function actionCharthari($id,$idp){
        // if (Yii::$app->user->identity->role=="user") {
        //     $id_owner = Yii::$app->user->id;
        //     if ($id=='all' && !empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
        //         SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
        //         perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND data.id_perangkat="'.$idp.'"
        //         AND WEEK(tgl)=WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
        //     }elseif ($id=='all' && empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT  CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
        //         SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
        //         perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND WEEK(tgl)=WEEK(NOW())
        //         GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
        //     }elseif($id=='curah_hujan' && empty($idp) ){
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
        //         FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat
        //         AND user.id = "'.$id_owner.'" AND WEEK(tgl) = WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }elseif($id=='curah_hujan' && !empty($idp) ){
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }elseif (empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.'
        //         FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat
        //         AND user.id = "'.$id_owner.'" AND WEEK(tgl) = WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }else{
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }
        // }else {
        //     if ($id=='all' && !empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
        //         SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
        //         perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND data.id_perangkat="'.$idp.'"
        //         AND WEEK(tgl) = WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
        //     }elseif ($id=='all' && empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari, AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin,
        //         SUM(curah_hujan) AS curah_hujan, AVG(temperature) AS temperature, AVG(tekanan_udara) AS tekanan_udara FROM data, perangkat,user WHERE
        //         perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND WEEK(tgl) = WEEK(NOW())
        //         GROUP BY hari ORDER BY DATE(tgl) ASC')->queryAll();
        //     }elseif($id=='curah_hujan' && empty($idp) ){
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }elseif($id=='curah_hujan' && !empty($idp) ){
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,SUM('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }elseif (empty($idp)) {
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }else{
        //         $charthari = Yii::$app->db->createCommand('SELECT CASE DAYNAME(tgl) WHEN "Monday" THEN "Senin" WHEN "Tuesday" THEN "Selasa"
        //             WHEN "Wednesday" THEN "Rabu" WHEN "Thursday" THEN "Kamis" WHEN "Friday" THEN "Jumat" WHEN "Saturday" THEN "Sabtu"
        //             WHEN "Sunday" THEN "Minggu" END AS hari,AVG('.$id.') AS '.$id.'
        //         FROM data WHERE WEEK(tgl) = WEEK(NOW()) AND id_perangkat ="'.$idp.'" GROUP BY hari ORDER BY DATE(tgl) ASC')
        //         ->queryAll();
        //     }
        // }

        $id_owner = Yii::$app->user->id;
        $query = Yii::$app->db->createCommand
        ('SELECT id_perangkat,perangkat.alias,perangkat.latitude,perangkat.longitude,DATE(tgl)as tgl, AVG(kelembaban) AS kelembaban,
        AVG(kecepatan_angin) AS kecepatan_angin, (SELECT arah_angin FROM data WHERE id_perangkat="'.$idp.'" AND DATE(tgl)=DATE(NOW())-1
        GROUP BY arah_angin ORDER BY count(arah_angin) DESC LIMIT 1) AS arah_angin, SUM(curah_hujan) AS curah_hujan, AVG(temperature)
        AS temperature,AVG(tekanan_udara) AS tekanan_udara FROM data,perangkat WHERE data.id_perangkat=perangkat.id AND
        id_perangkat="'.$idp.'" AND DATE(tgl)=DATE(NOW())-1')
        ->queryOne();

        $charthari = Yii::$app->db->createCommand('SELECT TIME_FORMAT(TIME(tgl), "%h:%i %p") AS waktu, AVG(temperature) AS temperature,
        AVG(kelembaban) AS kelembaban, AVG(kecepatan_angin) AS kecepatan_angin, SUM(curah_hujan) AS curah_hujan, AVG(tekanan_udara) AS 
        tekanan_udara FROM data,user,perangkat WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND 
        user.id = "'.$id_owner.'" AND id_perangkat = "'.$idp.'" AND DATE(tgl) = "'.$id.'" GROUP BY waktu ORDER BY
        TIME(tgl)')->queryAll();

        $piehari = Yii::$app->db->createCommand('SELECT CASE arah_angin WHEN "S" THEN "Selatan" WHEN "SW" THEN "Barat Daya" 
        WHEN "SE" THEN "Tenggara" WHEN "N" THEN "Utara" WHEN "NE" THEN "Timur Laut" WHEN "NW" THEN "Barat Laut" WHEN "E" 
        THEN "Timur" WHEN "W" THEN "Barat" END AS arah_angin, COUNT(arah_angin) AS jumlah FROM data,perangkat,user
        WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat AND user.id = "'.$id_owner.'" AND DATE(tgl) = "'.$id.'"
        AND id_perangkat = "'.$idp.'" GROUP BY arah_angin ORDER BY jumlah DESC')->queryAll();
        
        
        return $this->renderAjax('_charthari',[
            'query' => $query,
            'charthari' => $charthari,
            'piehari' => $piehari,
            'id' => $id,
            'idp' => $idp,
        ]);
    }



    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->getSession()->setFlash(
                        'success','Register Berhasil! Silahkan Login'
                    );
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

}
