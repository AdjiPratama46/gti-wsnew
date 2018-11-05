<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Permintaan */

$this->title = 'Detail Pengajuan';
?>
<div class="permintaan-view" style="padding:40px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>

    <center><h3><?= Html::encode($this->title) ?></h3></center>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'id_perangkat',
            //'id_user',
            'tgl_pengajuan',
            'tgl_tanggapan',
            [
              'attribute' => 'status',
              'format'=>'raw',
              'value' => function($model)
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
              'attribute' => 'pesan',
              'format'=>'raw',
              'value' => function($model)
                {
                  if($model->pesan == '')
                  {
                      return '<p class="text-warning">Menunggu Konfirmasi</p>';
                  }
                  else
                  {
                      return $model->pesan;
                  }
                },
            ],
        ],
    ]) ?>

</div>
