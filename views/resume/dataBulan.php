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
            [
                'attribute' => 'kelembaban',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'kecepatan_angin',
                'format'=>['decimal',2]
            ],
            
            'arah_angin',
              
            [
                'attribute' => 'curah_hujan',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'temperature',
                'format'=>['decimal',2]
            ],
            [
                'attribute' => 'tekanan_udara',
                'format'=>['decimal',2]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>