<?php
/* @var $this yii\web\View */


use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Data Resume';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<div class=\"progress\"><div class=\"progress-bar progress-bar-striped active\" aria-valuenow=\"100\" style=\"width:100%\"></div></div>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");

Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
echo '...';
 
Modal::end();
?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
    'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'tahun',
        'kelembaban',
        'kecepatan_angin',
        'arah_angin',
        'curah_hujan',
        'temperature',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Aksi',
            'template' => '{detail}',
            'buttons' => [
                'detail' => 
                    function ($url, $model, $key) {
                        return  Html::a('Detail',['bulan','tahun' => $model['tahun']],[
                            'class' => 'btn btn-success',
                            'data-toggle'=>'modal',
                            'data-target'=>'#myModal',
                            'data-title'=> '<center>Data Resume Bulanan</center>',
                            ]);
                    },
            ]
        ],
    ],
    ]); ?>
<?php Pjax::end(); ?>