<?php
/* @var $this yii\web\View */


use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

$this->title = 'Resume';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['resume/index']];
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title')
        var href = button.attr('href')
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<div class=\"progress\"><div class=\"progress-bar progress-bar-striped active\" aria-valuenow=\"100\" style=\"width:100%\"></div></div>')
        modal.find('.modal-content')
        modal.find('.modal-dialog').css('width','80%')
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

$gridColumns=[
    ['class' => 'yii\grid\SerialColumn'],
    'bulan',
    //'id_perangkat',
    //'tahun',

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
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Aksi',
        'template' => '{detail}',
        'buttons' => [
            'detail' =>
                function ($url, $model, $key) {
                    return  Html::a('Detail',['minggu','bulan' => $model['bulan'], 'id' => $model['id_perangkat'],'tahun' => $model['tahun']],[
                        'class' => 'btn btn-success',
                        'data-toggle'=>'modal',
                        'data-target'=>'#myModal',
                        'data-title'=> '<center>Data Resume Mingguan</center>',
                        ]);
                },
        ]
    ],
];
?>
<div class="resume-index">
    <div class="box box-info">
        <div class="box-body">
            <br>
            <div class="col-md-6" style="padding-left:0px;">
              <?php
                echo ExportMenu::widget([
                  'dataProvider' => $dataProvider,
                  'columns' => $gridColumns,
                  'target'=> '_blank',
                  'dropdownOptions' => [
                      'label' => 'Export',
                      'class' => 'btn ',
                      'style' => 'border-radius:0;'
                    ],
                  'columnSelectorOptions' => [
                    'disabled' => true,
                    'label' => 'Kolom',
                    'class' => 'btn',
                    'style' => 'visibility: hidden;width:0;height:0;position:absolute;'
                  ],
                  'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => [
                          'alertMsg' => 'Resume akan di export menjadi file CSV',
                      ],
                    ExportMenu::FORMAT_TEXT => [
                          'alertMsg' => 'Resume akan di export menjadi file TEXT',
                      ],
                    ExportMenu::FORMAT_PDF => [
                          'alertMsg' => 'Resume akan di export menjadi file PDF',
                      ],
                    ExportMenu::FORMAT_EXCEL => [
                          'alertMsg' => 'Resume akan di export menjadi file EXCEL',
                      ],
                    ExportMenu::FORMAT_EXCEL_X => false
                    ],
                  'filename' => date('YmdHis', mktime(date('H')+5)).'_WSResume',
                  'messages' => [
                    'allowPopups' =>  '',
                    'confirmDownload' => 'Lanjutkan proses export ?',
                    'downloadProgress' => 'Memproses file. silahkan tunggu...',
                    'downloadComplete' => 'Download selesai.'
                  ]
                ]);
                 ?>
            </div>
            <div class="col-md-6">
                <?php  echo $this->render('_search1', ['model' => $searchModel]); ?>
            </div>
            <br>
            <div id="tabel">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                    'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
                    'columns' =>$gridColumns
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
