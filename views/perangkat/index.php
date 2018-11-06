<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Perangkat;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerangkatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


if(Yii::$app->user->identity->role=='admin'){$this->title = 'Perangkat Aktif';}
elseif(Yii::$app->user->identity->role=='user'){$this->title = 'Perangkat Saya';}
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['perangkat/index']];
?>
<div class="perangkat-index">  <?php Pjax::begin(); ?>
    <div class="box box-info">
        <div class="box-body">
            <br>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        [
                          'attribute' => 'id_owner',
                          'value' => 'user.name',
                        ],
                        'alias',
                        [
                            'attribute'=>'tgl_instalasi',

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
                        'altitude',
                        [
                          'format'=>'raw',
                          'header' => 'Aksi',
                          'value' => function($model, $key, $index)
                            {

                                  return Html::a('Detail', ['view', 'id' => $model->id], ['class' => 'modal-form btn btn-sm btn-success']);


                            },
                        ],

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
                        'altitude',
                        [
                        'header' => 'Aksi',
                        'content' => function($model) {
                            return  Html::a('Ubah', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form btn btn-success btn-xs', 'id' => 'pindah-'.$model->id , 'data-pjax' => 0])

                          ;
                        }
                      ],
                    ],
                ]);
            }
            ?>

        </div>
    </div>
    <br>
    <br>
    <div class="box box-danger">
        <center><h3>
            <icon class="glyphicon glyphicon-map-marker"></icon>
            Peta Lokasi
        </h3></center>
        <div class="box-body">
        <?= $map->display() ?>
      </div>
    </div>
    <?php Pjax::end(); ?>
</div>
