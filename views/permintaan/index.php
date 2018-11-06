<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PermintaanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengajuan Perangkat';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="permintaan-index">
  <div class="box box-info">
      <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <br>
    <?php if (Yii::$app->user->identity->role!='admin'){ echo Html::a('Ajukan Perangkat', ['perangkat/create'], ['class' => 'modal-form btn btn-success']);} ?>
      <br><br>

    <?php
    if(Yii::$app->user->identity->role!='user'){
      echo GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
          'emptyText' => '<center class="text-danger">Tidak Ada Pengajuan</center>',

          'columns' =>[
                  ['class' => 'yii\grid\SerialColumn'],

                  //'id',
                  [
                    'attribute' => 'id_user',
                    'value' => 'user.name',
                  ],
                  'id_perangkat',
                  [
                    'attribute' => 'tgl_pengajuan',
                    'format' => ['date', 'php:d-m-Y'],
                    'filter'=>DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'tgl_pengajuan',
                        'template' => '{addon}{input}',
                              'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                                'clearBtn' => true,
                              ],
                              'clientEvents' => [
                                  'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                              ],
                    ])
                  ],

                  [
                    'attribute' => 'status',
                    'format'=>'raw',
                    'value' => function($model, $key, $index)
                      {
                        if($model->status == '0')
                        {
                            return '<p class="text-warning">Menunggu Konfirmasi</p>';
                        }
                        elseif($model->status == '1')
                        {
                            return '<p class="text-success">Pengajuan Diterima</p>';
                        }
                        elseif($model->status == '2')
                        {
                            return '<p class="text-danger">Pengajuan Ditolak</p>';
                        }
                      },
                  ],

                  [
                    'format'=>'raw',
                    'header' => 'Aksi',
                    'headerOptions' => ['style' => 'width:20%'],
                    'value' => function($model, $key, $index)
                      {
                        if($model->status == '0')
                        {
                            return Html::a('Setujui', ['terima', 'id' => $model->id], ['class' => 'btn btn-sm btn-success','data' => [
                                'confirm' => 'Anda yakin akan menyetujui pengajuan ini?',
                                'method' => 'post',
                            ],]).'&nbsp;'.Html::a('Tolak', ['tolak', 'id' => $model->id], ['class' => 'modal-form btn btn-sm btn-danger']);
                        }

                      },
                  ],
                  //'id_user',
                  //'status',

              ]]);
    }
    elseif(Yii::$app->user->identity->role!='admin'){
      echo GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
          'emptyText' => '<center class="text-danger">Tidak Ada Pengajuan</center>',

          'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],

                  //'id',
                  [
                    'attribute' => 'id_user',
                    'value' => 'user.name',
                  ],
                  'id_perangkat',
                  [
                    'attribute' => 'tgl_pengajuan',
                    'format' => ['date', 'php:d-m-Y'],
                    'filter'=>DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'tgl_pengajuan',
                        'template' => '{addon}{input}',
                              'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                                'clearBtn' => true,
                              ],
                              'clientEvents' => [
                                  'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                              ],
                    ])
                  ],
                  [
                    'attribute' => 'tgl_tanggapan',
                    'format' => ['date', 'php:d-m-Y'],
                    'filter'=>DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'tgl_tanggapan',
                        'template' => '{addon}{input}',
                              'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                                'clearBtn' => true,
                              ],
                              'clientEvents' => [
                                  'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                              ],
                    ]),
                    'format'=>'raw',
                    'value' => function($model, $key, $index)
                      {
                        if($model->tgl_tanggapan == '0000-00-00 00:00:00')
                        {
                            return '<p class="text-warning">Belum ada tanggapan</p>';
                        }
                        else{
                            $timestamps = strtotime($model->tgl_tanggapan);
                            $new_date = date('d-m-Y', $timestamps);
                            return $new_date;
                        }
                      },
                  ],
                  [
                    'attribute' => 'status',
                    'filter' => ['0'=>'Menunggu Konfirmasi', '1'=>'Pengajuan Diterima', '2'=>'Pengajuan Ditolak'],
                    'format'=>'raw',
                    'value' => function($model, $key, $index)
                      {
                        if($model->status == '0')
                        {
                            return '<p class="text-warning">Menunggu Konfirmasi</p>';
                        }
                        elseif($model->status == '1')
                        {
                            return '<p class="text-success">Pengajuan Diterima</p>';
                        }
                        elseif($model->status == '2')
                        {
                            return '<p class="text-danger">Pengajuan Ditolak</p>';
                        }
                      },
                  ],
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
          }
    ?>
    <?php Pjax::end(); ?>
  </div>
</div>

</div>
