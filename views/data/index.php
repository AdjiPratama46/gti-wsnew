<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\DataSearch;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data harian';
?>
<div class="data-index">
  <div style="background-color:#fff;padding:30px;padding-top:40px;">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_data',
            //'id_perangkat',
            'tgl:time',
            'kelembaban',
            'kecepatan_angin',
            'arah_angin',
            'curah_hujan',
            'temperature',
            'kapasitas_baterai',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
  </div>
</div>
