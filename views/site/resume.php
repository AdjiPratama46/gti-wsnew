<?php

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Resume Tahunan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">
    <div style="background-color:#fff;padding:30px;padding-top:40px;">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
        'emptyText' => '<center class="text-danger">Tidak ada data untuk ditampilkan</center>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bulan',
            'kelembaban',
            'kecepatan_angin',
            'jumlah',
            'curah_hujan',
            'temperature',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>