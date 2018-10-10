<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends Controller
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
                    'actions' => [
                        'index',
                        'view',
                        'update',
                        'create',
                        'delete'
                    ],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function(){
                        return (Yii::$app->user->identity->role=='admin');
                    }
                ],
                [
                    'actions' => [
                        'update',
                    ],
                    'allow' => true,
                    'roles' => ['@'],
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
                    'update',
                ],
                
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $time = time();
        $enc = sha1($time);
        $model = new Users();
        $md = md5($time);
        if ($model->load(Yii::$app->request->post())) {
            $enci = sha1($model->password); 
            if ($model->save(false)) {
                Yii::$app->db->createCommand()->update('user',
                [
                    // 'authKey' => 'test'.$model['id'].'key',
                    'password' =>  $enci,
                    'authKey' => base64_encode($enc),
                    'accessToken' =>  sha1($md),
                ] ,'id ='.$model['id'])->execute();
                // $model->authKey = Yii::$app->getSecurity()->generateRandomString();
                Yii::$app->getSession()->setFlash(
                    'success','Berhasil Menambahkan User Baru!'
                );
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // echo Yii::$app->user->identity->role;exit;
        if ($model->load(Yii::$app->request->post())) {
            $eci = sha1($model->confirm_password);
            $pas = $model->password;
            // echo $eci.' '.$pas;exit;
            if ($eci != $pas) {
                Yii::$app->getSession()->setFlash(
                    'danger','Password Lama Tidak Sesuai, Coba Masukkan Kembali Dengan Benar'
                );
            }else{
                if(!empty($model->new_password)){
                    $model->password = sha1($model->new_password);
                  }
                    if($model->save(false)){
                        Yii::$app->getSession()->setFlash(
                            'success','Data saved!'
                        );
                    }
                    return $this->redirect(['update', 'id' => $model->id]);
            }
          
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash(
            'success','Berhasil Menghapus User!'
        );
        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
