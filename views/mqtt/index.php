<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KonfigurasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Riwayat Konfigurasi';
$this->params['breadcrumbs'][] = $this->title;

$jam =array(
      60 => '1 jam' ,
      120 => '2 jam' ,
      180 => '3 jam' ,
      240 => '4 jam' ,
      300 => '5 jam' ,
      360 => '6 jam' ,
      420 => '7 jam' ,
      480 => '8 jam' ,
      540 => '9 jam' ,
      600 => '10 jam' ,
      660 => '11 jam' ,
      720 => '12 jam' ,
      780 => '13 jam' ,
      840 => '14 jam' ,
      900 => '15 jam' ,
      960 => '16 jam' ,
      1020 => '17 jam' ,
      1080 => '18 jam' ,
      1140 => '19 jam' ,
      1200 => '20 jam' ,
      1260 => '21 jam' ,
      1320 => '22 jam' ,
      1380 => '23 jam' ,
      1440 => '24 jam'
    );
?>
<div class="konfigurasi-index">
  <div class="box box-info">
      <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <br><br><br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
        'emptyText' => '<center class="text-danger">Tidak Ada Pengajuan</center>',

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
              'attribute' => 'timestamp',
              'format' => ['date', 'php:d-m-Y'],
              'filter'=>DatePicker::widget([
                  'model' => $searchModel,
                  'attribute' => 'timestamp',
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
            //'id',
            [
              'attribute' => 'id_user',
              'value' => 'user.name',
            ],
            [
              'attribute' => 'interval',
              'filter' => $jam,
              'headerOptions' => ['style'=>'width:10%;'],
              'format'=>'raw',
              'value' => function($model, $key, $index)
                {
                  $x=$model->interval/60;

                  return $x.' jam';
                },
            ],
            'ip_server',
            'no_hp',
            [
              'attribute' => 'gsm_to',
              'format'=>'raw',
              'value' => function($model, $key, $index)
                {
                  return $model->gsm_to.' menit';
                },
            ],
            [
              'attribute' => 'gps_to',
              'format'=>'raw',
              'value' => function($model, $key, $index)
                {
                  return $model->gsm_to.' menit';
                },
            ],
            'ussd_code',
            //'timestamp',

        ],
    ]); ?>
    <?php Pjax::end(); ?>
  </div></div>
</div>
