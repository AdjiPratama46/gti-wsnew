<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TemptableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perangkat Tidak Aktif';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temptable-index">
<?php Pjax::begin(); ?>
  <div class="box box-info">
      <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <br><br><br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'id_perangkat',
            'latitude',
            'longitude',
            'altimeter',
            //'temperature',
            //'kelembapan',
            //'tekanan_udara',
            //'kecepatan_angin',
            //'arah_angin',
            //'curah_hujan',
            //'timestamp',
            //'status',

        ],
    ]); ?>

  </div></div><br><br>
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
