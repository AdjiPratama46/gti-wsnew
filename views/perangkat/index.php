<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Perangkat;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerangkatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perangkat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-index">
    <div class="box">
        <div class="box-body">
            <br>
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php echo Html::a('Tambah Perangkat', ['perangkat/create'], ['class' => 'modal-form btn btn-success']); ?>
            <br><br>
            <?php
            if (Yii::$app->user->identity->role =='admin') {
                echo 
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                    'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
    
                        'id',
                        'id_owner',
                        'alias',
                        [
                            'attribute'=>'tgl_instalasi',
                            'value'=>'tgl_instalasi',
                            'format'=>'raw',
                            'filter'=>DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_instalasi',
                                'template' => '{addon}{input}',
                                      'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-m-d',
                                        'clearBtn' => true,
                                      ],
                                      'clientEvents' => [
                                          'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                                      ],
                            ])
                        ],
                        
                        'longitude',
                        'latitude',
                        ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'template'=>'{view} {update} {delete}',
                        'headerOptions'=> ['style'=> 'width:80px;'],
                        'buttons'=>[
                            'delete' => function ($url, $model) {	
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], ['data' => [
                                    'confirm' => 'Anda yakin akan menghapus perangkat ini?',
                                    'method' => 'post',
                                ],]);
                            },
                            'update' => function ($url, $model) {	
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form', 'id' => 'pindah-'.$model->id , 'data-pjax' => 0]);
                            },
                            'view' => function ($url, $model) {	
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['perangkat/view', 'id' => $model->id], ['class' => 'modal-form', 'id' => 'pindah-'.$model->id , 'data-pjax' => 0]);
                            },
                        ]
                    ]
                    ],
                ]);
            }elseif (Yii::$app->user->identity->role =='user') {
                echo 
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                    'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
    
                        'id',
                        'alias',
                        [
                            'attribute'=>'tgl_instalasi',
                            'value'=>'tgl_instalasi',
                            'format'=>'raw',
                            'filter'=>DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_instalasi',
                                'template' => '{addon}{input}',
                                      'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-m-d',
                                        'clearBtn' => true,
                                      ],
                                      'clientEvents' => [
                                          'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                                      ],
                            ])
                        ],
                        'longitude',
                        'latitude',
                        [
                        'header' => 'Aksi',
                        'headerOptions'=> ['style'=> 'width:118px;'],
                        'content' => function($model) {
                            return  Html::a('Pindah', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form btn btn-success btn-xs', 'id' => 'pindah-'.$model->id , 'data-pjax' => 0])
                            .'&nbsp;'.
                              Html::a('Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-xs','data' => [
                                    'confirm' => 'Anda yakin akan menghapus perangkat ini?',
                                    'method' => 'post',
                                ],])
                          ;
                        }
                      ],
                    ],
                ]);
            }
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <br>
    <hr style="border:0.5px solid #4F7BC3;width:60%;">
    <br>
    <div style="background-color:#fff;padding:10px;">
        <h3>
            <icon class="glyphicon glyphicon-map-marker"></icon>
            Peta Lokasi
        </h3>
        <?= $map->display() ?>
    </div>
</div>
