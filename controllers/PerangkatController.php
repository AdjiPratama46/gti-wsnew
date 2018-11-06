<?php

namespace app\controllers;

use Yii;
use app\models\Perangkat;
use app\models\Temptable;
use app\models\Permintaan;
use app\models\Tperangkat;
use app\models\Maps;
use app\models\Data;
use yii\helpers\Html;
use app\models\PerangkatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * PerangkatController implements the CRUD actions for Perangkat model.
 */
class PerangkatController extends Controller
{
    /**
     * {@inheritdoc}
     */


     public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderPartial($view, $params);
        }
        return parent::render($view, $params);
    }

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Perangkat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerangkatSearch();
        $model = new Perangkat();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $showmap = new Maps();
            $map = $showmap->showMaps($dataProvider->query->all());


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'map' => $map,
        ]);


    }


    /**
     * Displays a single Perangkat model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Perangkat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $model = new Tperangkat();
        $perangkt = ArrayHelper::map(Temptable::find()->select('id_perangkat')->distinct()->where(['status'=>0])->all(),'id_perangkat','id_perangkat');

        if ($model->load(Yii::$app->request->post())) {

          $model1 = new Permintaan();
          $model1->id_perangkat=$model->idp;
          $model1->id_user=Yii::$app->user->identity->id;
          if($model1->save()){
            Temptable::updateAll(['status' => 1], ['id_perangkat' => $model->idp]);
          }


          /*
            $dataM = Temptable::find()->where(['id_perangkat'=>$model->idp])->orderBy(['timestamp' => SORT_ASC])->all();
            $jml=0;
            $idnya='id:';
            foreach ($dataM as $datas) {
                $model1 = new Perangkat();

                $model1->id=$datas->id_perangkat;
                $model1->alias=$datas->id_perangkat;
                $model1->id_owner=Yii::$app->user->identity->id;
                $model1->tgl_instalasi=$datas->timestamp;
                $model1->longitude=$datas->longitude;
                $model1->latitude=$datas->latitude;
                $model1->altitude=$datas->altimeter;

                $cek = Perangkat::find()->where(['id'=>$model->idp])->one();

                if(empty($cek)){
                  $model1->save();
                }
                else if(!empty($cek)){
                    if(($cek->longitude != $datas->longitude) || ($cek->latitude != $datas->latitude) || ($cek->altitude != $datas->altimeter)){
                        $model2 = Perangkat::find($model->idp)->one();
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
          */
            $msg='Permintaan penambahan perangkat telah diajukan';

                Yii::$app->getSession()->setFlash(
                    'success',$msg
                );
                  return $this->redirect(['permintaan/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'perangkt' => $perangkt,
        ]);
    }

    /**
     * Updates an existing Perangkat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          Yii::$app->getSession()->setFlash(
              'success','Perangkat dipindahkan !'
          );
            return $this->redirect(['perangkat/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Perangkat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
      if(empty(Data::find()->where(['id_perangkat' => $id])->all())){
        Yii::$app->getSession()->setFlash(
            'success','perangkat berhasil dihapus !'
        );
          $this->findModel($id)->delete();
      }else{
        Yii::$app->getSession()->setFlash(
            'danger','perangkat tidak dapat dihapus !'
        );
      }


        return $this->redirect(['index']);
    }

    /**
     * Finds the Perangkat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Perangkat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perangkat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
