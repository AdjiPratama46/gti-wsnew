<?php
/* @var $this yii\web\View */


use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Data Resume';
$this->params['breadcrumbs'][] = $this->title;
$js=<<<js
    $('#modalButton').on('click', function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

Modal::begin([
    'header' => 'Data Resume Mingguan',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="resume-index">
    <div class="box">
        <div class="box-body">
            <?= $this->render('_search'); ?>
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => '<center class="text-danger">Tidak ada data untuk ditampilkan</center>',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'bulan',
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
                                        return  Html::button('Detail',['value' =>  Url::to(['resume/minggu']),'class' => 'btn btn-info','id' => 'modalButton']);
                                    },
                            ]
                        ],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
