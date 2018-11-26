<?php

use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Perangkat;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\Html;
/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;

$this->title = 'Dashboard';
$urlData = Url::to(['site/get']);
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/index']];

$sql = 'SELECT perangkat.id,data.id_perangkat FROM perangkat,data WHERE
perangkat.id=data.id_perangkat';
$perangkats = ArrayHelper::map(Perangkat::findBySql($sql)->all(),'id','id');
$perangkatid = $query['id_perangkat'];
$urlC = Url::to(['site/chart']);
$this->registerJs("
    $('#bx-tl').on('click ', function (event) {
        $('#bx-bd').slideDown(500);
        if ($('#ls').text()=='Lihat Selengkapnya') {
            $('#ls').text('Sembunyikan');
            $('#ix').removeClass('fa-plus').addClass('fa-minus');
        }else{
            $('#bx-bd').slideUp(500);
            $('#ls').text('Lihat Selengkapnya');
            $('#ix').removeClass('fa-minus').addClass('fa-plus');
        }
    })
    $('#id-perangkat').change(function(){
        var id = $('#id-perangkat').val();
        $.ajax({
            type :'GET',
            url : '{$urlData}',
            data:'id='+id,
            success : function(data){
                $('#tabel').html(data);
            }
        });
    });
    ");
?>
<div class="site-index" id="tabel">

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="ion ion-ios-people"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah User</span>
                            <span class="info-box-number"><?= $jmluser['jumlah_user']?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="ion ion-ios-construct"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Perangkat</span>
                            <span class="info-box-number"><?= $jmlperang['jml']?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red">
                            <i class="ion ion-ios-download"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Data Masuk</span>
                            <span class="info-box-number"><?= $dasuk['jml']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                    <?php
                        if (empty($query['id_perangkat'])) {
                            echo 'Belum Ada Data';
                        }else{
                            echo $query['id_perangkat'];
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <?php
                        if (!empty($perangkats)) {
                            echo Select2::widget([
                                'name' => 'id-perangkat',
                                'id' => 'id-perangkat',
                                'value' => $query['id_perangkat'],
                                'data' => $perangkats,
                                'options' => ['placeholder' => 'Pilih Perangkat'],
                                'pluginOptions' => [
                                    'width' => '200px',
                                ],
                            ]);
                        }
                        ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="data">
                                <center>
                                    <h4>
                                        <b>Nama Perangkat</b>
                                    </h4>
                                    <h4>
                                    <?php
                                    if (empty($query['alias'])) {
                                        echo 'Belum Ada Data';

                                    }else{
                                        echo $query['alias'];
                                    }
                                    ?>
                                    </h4>
                                </center>
                                <hr style="border:0.5px solid #4F7BC3;">
                                <center>
                                    <h4>
                                        <b>Kordinat</b>
                                    </h4>
                                    <h4>
                                    <?php
                                    if (empty($query['latitude']) AND empty($query['longitude'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $query['latitude'] .','. $query['longitude'];
                                    }
                                    ?>
                                    </h4>
                                </center>
                                <hr style="border:0.5px solid #4F7BC3;">
                                <h4 class="text-center">
                                <?php
                                    if (empty($query['tgl'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        $timestamps = strtotime($query['tgl']);
                                        $new_date = 'Update terakhir tanggal '.date('d F Y', $timestamps);
                                        echo $new_date;
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <p class="text-center">Arah Angin</p>
                                            <h3>
                                            <?php
                                                if (empty($query['arah_angin'])){
                                                    echo 'null';
                                                }else{
                                                    if ($query['arah_angin'] == 'W') {
                                                        echo 'Barat';
                                                    }elseif ($query['arah_angin'] == 'S') {
                                                        echo 'Selatan';
                                                    }elseif ($query['arah_angin'] == 'N') {
                                                        echo 'Utara';
                                                    }elseif ($query['arah_angin'] == 'E') {
                                                        echo 'Timur';
                                                    }elseif ($query['arah_angin'] == 'SE') {
                                                        echo 'Tenggara';
                                                    }elseif ($query['arah_angin'] == 'SW') {
                                                        echo 'Barat Daya';
                                                    }elseif ($query['arah_angin'] == 'NW') {
                                                        echo 'Barat Laut';
                                                    }elseif ($query['arah_angin'] == 'NE') {
                                                        echo 'Timur Laut';
                                                    }
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-compass"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <p class="text-center">Kelembaban</p>
                                            <h3>
                                            <?php
                                                if (empty($query['kelembaban'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($query['kelembaban'])) ;
                                                }
                                                ?>
                                                rh
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-water"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <p class="text-center">Temperature</p>
                                            <h3>
                                            <?php
                                                if (empty($query['temperature'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($query['temperature'])) ;
                                                }
                                            ?>
                                                &deg;
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-thermometer"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Curah Hujan</p>
                                            <h3>
                                            <?php
                                                if (empty($query['curah_hujan'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($query['curah_hujan'])) ;
                                                }
                                                ?>
                                                mm
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-rainy"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <p class="text-center">Kecepatan Angin</p>
                                            <h3>
                                            <?php
                                                if (empty($query['kecepatan_angin'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($query['kecepatan_angin'])) ;
                                                }
                                                ?>
                                                mph
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-speedometer"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="small-box bg-maroon">
                                        <div class="inner">
                                            <p class="text-center">Tekanan Udara</p>
                                            <h3>
                                            <?php
                                                if (empty($query['tekanan_udara'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($query['tekanan_udara'])) ;
                                                }
                                            ?>
                                                mb
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-timer"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="nav nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tahun" id="year">Tahun</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#bulan" id="month">Bulan</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#minggu" id="week">Minggu</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#hari" id="day">Hari</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tahun" class="tab-pane fade in active">
                        <?= $this->render('charttahun', [
                                  'chart' => $chart,
                                  'pie' => $pie,
                                  'query' => $query
                              ]);
                          ?>
                    </div>
                    <div id="bulan" class="tab-pane fade">
                        <?= $this->render('chartbulan', [
                                  'chartbulan' => $chartbulan,
                                  'piebulan'=>$piebulan,
                                  'query' => $query
                              ]);
                          ?>
                    </div>
                    <div id="minggu" class="tab-pane fade">
                        <?= $this->render('chartminggu', [
                                  'chartminggu' => $chartminggu,
                                  'pieminggu'=>$pieminggu,
                                  'query' => $query
                              ]);
                          ?>
                    </div>
                    <div id="hari" class="tab-pane fade">
                        <?= $this->render('charthari', [
                                'charthari' => $charthari,
                                'piehari' => $piehari,
                                'query' => $query
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-warning collapsed-box">
                <div class="box-header with-border">
                    <center>
                        <h3 class="box-title" id="ls">Lihat Selengkapnya</h3>
                    </center>
                    <div class="box-tools pull-right" id="bx-tl">
                        <button
                            type="button"
                            class="btn btn-box-tool"
                            data-widget="collapse"
                            data-toggle="tooltip"
                            title="Collapse">
                            <i class="fa fa-plus" id="ix"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" id="bx-bd">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                        'emptyText' => '<center class="text-danger">Tidak Ada Data Untuk Ditampilkan</center>',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            ['attribute' => 'pukul',
                              'value' => 'tgl',
                              'format' =>  ['date', 'php:H:i'],
                            ],
                            'kelembaban',
                            'kecepatan_angin',
                            'arah_angin',
                            'curah_hujan',
                            'temperature',
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
                <div class="box-footer text-center" id="myBox">
                    <?php echo Html::a('Lihat Data Lengkap', ['data/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
