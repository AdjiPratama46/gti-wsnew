<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Data Bulan';
?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'bulan',
            'kelembaban',
            'kecepatan_angin',
            'arah_angin',
            'curah_hujan',
            'temperature',
        ],
    ]); ?>
<?php Pjax::end(); ?>