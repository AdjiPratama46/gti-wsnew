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

        $chart = Yii::$app->db->createCommand
        ('SELECT
        MONTHNAME(tgl) AS bulan,
        AVG(kelembaban) AS kelembaban,
        AVG(kecepatan_angin) AS kecepatan_angin,
        (
            SELECT
                arah_angin
            FROM
                data
            WHERE MONTHNAME(tgl) = bulan
            GROUP BY
                arah_angin
            ORDER BY
                count(arah_angin) DESC
            LIMIT 1
        ) AS arah_angin,
        AVG(curah_hujan) AS curah_hujan,
        AVG(temperature) AS temperature
    FROM
        data
    WHERE YEAR (tgl) = YEAR (NOW())
    GROUP BY
        bulan
    ORDER BY
        MONTH (tgl) ASC')->queryAll();
        $pie = Yii::$app->db->createCommand
        ('SELECT arah_angin, COUNT(arah_angin) AS jumlah FROM data WHERE YEAR (tgl) = YEAR (NOW()) GROUP BY arah_angin')->queryAll();
        // print_r($pie);exit;
        $perangkat = Yii::$app->db->createCommand
        ('SELECT perangkat.id,perangkat.alias,perangkat.longitude,perangkat.latitude,data.tgl FROM perangkat,data WHERE
        data.id_perangkat=perangkat.id AND DATE(data.tgl) = DATE(NOW())-1 AND data.id_perangkat ="'.$model['id'].'" ')
        ->queryOne();
        $suhu = Yii::$app->db->createCommand
        ('SELECT AVG(temperature) as suhu FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" ')
        ->queryOne();
        $kelembaban = Yii::$app->db->createCommand
        ('SELECT AVG(kelembaban) as kelembaban FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" ')
        ->queryOne();
        $data = Yii::$app->db->createCommand
        ('SELECT date(tgl) AS tgl FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" ')
        ->queryOne();
        $arangin = Yii::$app->db->createCommand
        ('SELECT arah_angin, count(*) as jumlah FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" GROUP BY arah_angin ORDER BY jumlah DESC')
        ->queryOne();
        $kangin = Yii::$app->db->createCommand
        ('SELECT AVG(kecepatan_angin) as kecepatan_angin FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" ')
        ->queryOne();
        $curjan = Yii::$app->db->createCommand
        ('SELECT AVG(curah_hujan) as curah_hujan FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$model['id'].'" ')
        ->queryOne();
        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        ('SELECT count(*) as jml FROM data WHERE DAY(tgl)=DAY(NOW())')
        ->queryOne();

        return $this->render('index', [
            'perangkat' => $perangkat,
            'curjan' => $curjan,
            'kangin' => $kangin,
            'kelembaban' => $kelembaban,
            'suhu' => $suhu,
            'arangin' => $arangin,
            'model' => $model,
            'data' => $data,
            'jmluser' => $jmluser,
            'paktif'=> $paktif,
            'jmlperang' => $jmlperang,
            'dasuk' => $dasuk,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chart' => $chart,
            'pie' => $pie,
        ]);
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

        $perangkat = Yii::$app->db->createCommand
        ('SELECT perangkat.id,perangkat.alias,perangkat.longitude,perangkat.latitude,data.tgl FROM perangkat,data WHERE
        data.id_perangkat=perangkat.id AND DATE(data.tgl) = DATE(NOW())-1 AND data.id_perangkat ="'.$id.'" ')
        ->queryOne();
        $suhu = Yii::$app->db->createCommand
        ('SELECT AVG(temperature) as suhu FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" ')
        ->queryOne();
        $kelembaban = Yii::$app->db->createCommand
        ('SELECT AVG(kelembaban) as kelembaban FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" ')
        ->queryOne();
        $data = Yii::$app->db->createCommand
        ('SELECT date(tgl) AS tgl FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" ')
        ->queryOne();
        $arangin = Yii::$app->db->createCommand
        ('SELECT arah_angin, count(*) as jumlah FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" GROUP BY arah_angin ORDER BY jumlah DESC')
        ->queryOne();
        $kangin = Yii::$app->db->createCommand
        ('SELECT AVG(kecepatan_angin) as kecepatan_angin FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" ')
        ->queryOne();
        $curjan = Yii::$app->db->createCommand
        ('SELECT AVG(curah_hujan) as curah_hujan FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'" ')
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
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM data WHERE DATE(tgl) = DATE(NOW())-1 AND id_perangkat= "'.$id.'"',
            'sort' =>false,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('_index', [
            'perangkat' => $perangkat,
            'curjan' => $curjan,
            'kangin' => $kangin,
            'kelembaban' => $kelembaban,
            'suhu' => $suhu,
            'arangin' => $arangin,
            'data' => $data,
            'jmluser' => $jmluser,
            'paktif'=> $paktif,
            'jmlperang' => $jmlperang,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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
