<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\DataSearch;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Harian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">
  <div class="box">
    <div class="box-body">
    <br>
      <?php Pjax::begin(); ?>
      <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
          'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],

              ['attribute' => 'perangkat',
                'value' => 'perangkat.alias'
              ],
              ['attribute' => 'pukul',
                'value' => 'tgl',
                'format' =>  ['date', 'php:H:i'],
              ],
              'kelembaban',
              'kecepatan_angin',
              'arah_angin',
              'curah_hujan',
              'temperature',
              'kapasitas_baterai',
          ],
      ]); ?>
      <?php Pjax::end(); ?>
      </div>
  </div>
</div>
