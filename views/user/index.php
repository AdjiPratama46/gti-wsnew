<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['user/index']];
?>
<div class="users-index">
    <div class="box box-info">
        <div class="box-body">
        <br>
        <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Tambah User', ['create'], ['class' => 'modal-form btn btn-success']) ?>
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
                    [
                      'attribute' => 'role',
                      'filter' => ['admin'=>'Admin', 'user'=>'User'],
                    ],
                    [
                      'attribute' => 'status',
                      'filter' => ['1'=>'Aktif', '0'=>'Tidak aktif'],
                      'format'=>'raw',
                      'value' => function($model, $key, $index)
                        {
                            if($model->status == '1')
                            {
                                return Html::a('Aktif', ['setstatus', 'id' => $model->id], ['class' => 'btn btn-sm btn-success','data' => [
                                    'confirm' => 'Anda yakin akan menonaktifkan user ini?',
                                    'method' => 'post',
                                ],]);
                            }
                            else
                            {
                                return Html::a('Tidak aktif', ['setstatus', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger','data' => [
                                    'confirm' => 'Anda yakin akan mengaktifkan user ini?',
                                    'method' => 'post',
                                ],]);
                            }
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'template'=>' {update}',
                        'buttons'=>[
                            'view' => function ($url, $model) {
                                return Html::a('Detail', ['user/view', 'id' => $model->id], ['class' => 'modal-form btn btn-sm btn-primary']).'&nbsp';
                            },
                            'update' => function ($url, $model) {
                                return Html::a('Edit', ['user/update', 'id' => $model->id], ['class' => 'modal-form btn btn-sm btn-primary']);
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
