<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Data Minggu';
?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => '<center class="text-danger">Tidak ada data untuk ditampilkan</center>',
        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'minggu',
            'kelembaban',
            'kecepatan_angin',
            'arah_angin',
            'curah_hujan',
            'temperature',
        ],
    ]); ?>
<?php Pjax::end(); ?>