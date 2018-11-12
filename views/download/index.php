<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DownloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Download Data';
$this->params['breadcrumbs'][] = $this->title;
$kolom=[
    ['class' => 'yii\grid\SerialColumn'],

    //'id_data',
    'id_perangkat',
    'tgl',
    'temperature',
    'kelembaban',
    'kecepatan_angin',
    'arah_angin',
    'curah_hujan',
    'tekanan_udara',
];
?>
<div class="data-index">
  <div class="box box-info">
      <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <center><?php
      echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $kolom,
        'target'=> '_blank',
        'dropdownOptions' => [
            'label' => 'Download Data',
            'class' => 'btn btn-success',
            'style' => 'border-radius:0;color:white;padding-left:30px;padding-right:30px;'
          ],
        'columnSelectorOptions' => [
          'disabled' => true,
          'label' => 'Kolom',
          'class' => 'btn',
          'style' => 'visibility: hidden;width:0;height:0;position:absolute;'
        ],
        'exportConfig' => [
          ExportMenu::FORMAT_HTML => false,
          ExportMenu::FORMAT_CSV => [
                'alertMsg' => 'Data akan di export menjadi file CSV',
            ],
          ExportMenu::FORMAT_TEXT => [
                'alertMsg' => 'Data akan di export menjadi file TEXT',
            ],
          ExportMenu::FORMAT_PDF => [
                'alertMsg' => 'Data akan di export menjadi file PDF',
            ],
          ExportMenu::FORMAT_EXCEL => [
                'alertMsg' => 'Data di export menjadi file EXCEL 95+',
            ],
          ExportMenu::FORMAT_EXCEL_X => [
                'alertMsg' => 'Data di export menjadi file EXCEL 2007+',
            ],
          ],
        'filename' => date('YmdHis', mktime(date('H')+5)).'_WSData',
        'messages' => [
          'allowPopups' =>  '',
          'confirmDownload' => 'Lanjutkan proses export ?',
          'downloadProgress' => 'Memproses file. silahkan tunggu...',
          'downloadComplete' => 'Download selesai.'
        ]
      ]);
       ?></center>
       <br><hr style="border:0.5px solid #00C0EF;width:60%;"><br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => "Preview. Jumlah data : <b id='totaldata'>{totalCount}</b> ",
        'emptyText' => '<center class="text-danger">Tidak Ada Data, silahkan pilih perangkat, bulan, dan tahun</center>',
        'columns' => $kolom
    ]); ?>
    <?php Pjax::end(); ?>
  </div></div>
</div>
