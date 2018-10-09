<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <div class="box box-info">
        <div class="box-body">
        <br>
        <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Tambah Users', ['create'], ['class' => 'modal-form btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    'username',
                    // 'password',
                    'role',
                    'accessToken',

                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'template'=>'{view} {update} {delete}',
                        'buttons'=>[
                            'view' => function ($url, $model) {	
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['user/view', 'id' => $model->id], ['class' => 'modal-form', 'id' => 'view-'.$model->id , 'data-pjax' => 0]);
                            },
                            'delete' => function ($url, $model) {	
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], ['data' => [
                                    'confirm' => 'Anda yakin akan menghapus user ini?',
                                    'method' => 'post',
                                ],]);
                            }
                        ]
                    ]
                ],
            ]); ?>
    <?php Pjax::end(); ?>
        </div>
    </div>
</div>