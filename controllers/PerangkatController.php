<?php

namespace app\controllers;

use Yii;
use app\models\Perangkat;
use app\models\Maps;
use app\models\Data;
use yii\helpers\Html;
use app\models\PerangkatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
        $map = $showmap->showMaps(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all());

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
        $model = new Perangkat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          Yii::$app->getSession()->setFlash(
              'success','Perangkat tersimpan !'
          );
            return $this->redirect(['perangkat/index']);
        }

        return $this->render('create', [
            'model' => $model,
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
