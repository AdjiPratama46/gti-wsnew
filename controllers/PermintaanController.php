<?php

namespace app\controllers;

use Yii;
use app\models\Permintaan;
use app\models\Perangkat;
use app\models\Data;
use app\models\Temptable;
use app\models\PermintaanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PermintaanController implements the CRUD actions for Permintaan model.
 */
class PermintaanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
          'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                  'actions' => [
                      'index',
                      'view',
                      'create',
                      'update',
                      'delete',
                      'tolak',
                      'terima',
                  ],
                  'allow' => true,
                  'matchCallback' => function(){
                      return (Yii::$app->user->identity->role=='admin');
                  }
                ],
                [
                  'actions' => [
                      'index',
                      'view',
                  ],
                  'allow' => true,
                  'matchCallback' => function(){
                      return (Yii::$app->user->identity->role=='user');
                  }
                ],
            ],
        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Permintaan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PermintaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permintaan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Permintaan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Permintaan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Permintaan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Permintaan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionTolak($id){

      $model = $this->findModel($id);
      $model->scenario = 'tolak';
      $model->status=2;
      $model->tgl_tanggapan=date('Y-m-d H:i:s');

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Temptable::updateAll(['status' => 0], ['id_perangkat' => $model->id_perangkat]);
        $msg='Tanggapan telah dikirim';

            Yii::$app->getSession()->setFlash(
                'success',$msg
            );
              return $this->redirect(['permintaan/index']);
      }

      return $this->renderAjax('update', [
          'model' => $model,
      ]);


    }

    public function actionTerima($id){
      $model = $this->findModel($id);
      $model->status=1;
      $model->pesan='Permintaan Anda telah disetujui';
      $model->tgl_tanggapan=date('Y-m-d H:i:s');

      $dataM = Temptable::find()->where(['id_perangkat'=>$model->id_perangkat])->orderBy(['timestamp' => SORT_ASC])->all();
      $jml=0;
      $idnya='id:';
      foreach ($dataM as $datas) {
          $model1 = new Perangkat();

          $model1->id=$datas->id_perangkat;
          $model1->alias=$datas->id_perangkat;
          $model1->id_owner=$model->id_user;
          $model1->tgl_instalasi=$datas->timestamp;
          $model1->longitude=$datas->longitude;
          $model1->latitude=$datas->latitude;
          $model1->altitude=$datas->altimeter;

          $cek = Perangkat::find()->where(['id'=>$model->id_perangkat])->one();

          if(empty($cek)){
            $model1->save();
          }
          else if(!empty($cek)){
              if(($cek->longitude != $datas->longitude) || ($cek->latitude != $datas->latitude) || ($cek->altitude != $datas->altimeter)){
                  $model2 = Perangkat::find($model->id_perangkat)->one();
                  $model2->tgl_instalasi=$datas->timestamp;
                  $model2->longitude=$datas->longitude;
                  $model2->latitude=$datas->latitude;
                  $model2->altitude=$datas->altimeter;
                  $model2->save();
              }
          }

          $model3 = new Data();
          $model3->id_perangkat=$datas->id_perangkat;
          $model3->tgl=$datas->timestamp;
          $model3->kelembaban=$datas->kelembapan;
          $model3->kecepatan_angin=$datas->kecepatan_angin;
          $model3->arah_angin=$datas->arah_angin;
          $model3->curah_hujan=$datas->curah_hujan;
          $model3->temperature=$datas->temperature;
          $model3->tekanan_udara=$datas->tekanan_udara;
          $model3->save();

          $moddels = Temptable::find()->where(['id'=>$datas->id])->one();
          $moddels->delete();
          $idnya=$idnya.','.$datas->id;
          $jml=$jml+1;
    }
    $model->save();
    $msg='Perangkat telah ditambahkan. Jumlah data terisi : '.$jml;

        Yii::$app->getSession()->setFlash(
            'success',$msg
        );
          return $this->redirect(['perangkat/index']);
  }

    /**
     * Finds the Permintaan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Permintaan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Permintaan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
