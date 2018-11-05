<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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

    <br><br><br>

    <?= GridView::widget([
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
            'timestamp',
            [
              'attribute' => 'status',
              'format'=>'raw',
              'value' => function($model, $key, $index)
                {
                  if($model->status == '0')
                  {
                      return '<p class="text-danger">Menunggu Konfirmasi</p>';
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
                      return Html::a('Setujui', ['setstatus', 'id' => $model->id], ['class' => 'btn btn-sm btn-success','data' => [
                          'confirm' => 'Anda yakin akan menyetujui pengajuan ini?',
                          'method' => 'post',
                      ],]).'&nbsp;'.Html::a('Tolak', ['setstatus', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger','data' => [
                          'confirm' => 'Anda yakin akan menolak pengajuan ini?',
                          'method' => 'post',
                      ],]);
                  }

                },
            ],
            //'id_user',
            //'status',

        ],
    ]); ?>
    <?php Pjax::end(); ?>
  </div>
</div>
</div>
