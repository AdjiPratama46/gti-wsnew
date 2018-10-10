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

$this->title = 'Dashboard';
$urlData = Url::to(['site/get']);
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->identity->role=='admin'){
  $sql = 'SELECT perangkat.id,data.id_perangkat FROM perangkat,data WHERE
  perangkat.id=data.id_perangkat AND DATE(data.tgl)= DATE(NOW())-1' ;

}
else{
  $sql = 'SELECT perangkat.id,data.id_perangkat FROM perangkat,data WHERE
  perangkat.id=data.id_perangkat AND DATE(data.tgl)= DATE(NOW())-1 AND perangkat.id_owner ="'.Yii::$app->user->identity->id.'" ';
}

$perangkats = ArrayHelper::map(Perangkat::findBySql($sql)->all(),'id','id');

$this->registerJs("
    $('.btn-box-tool').on('click ', function (event) {
            $('.box-body').slideDown(1000);
            if ($('#ls').text()=='Lihat Selengkapnya') {
                $('#ls').text('Sembunyikan');
            }else{
                $('#ls').text('Lihat Selengkapnya');
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
    <?php
      if(Yii::$app->user->identity->role=='admin'){
     ?>
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
                        <span class="info-box-icon bg-yellow">
                            <i class="ion ion-ios-construct"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Perangkat</span>
                            <span class="info-box-number"><?= $jmlperang['jml']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                    <?php
                        if (empty($perangkat['id'])) {
                            echo 'Belum Ada Data';
                        }else{
                            echo $perangkat['id'];
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <?php
                        if (!empty($perangkats)) {
                            echo Select2::widget([
                                'name' => 'id-perangkat',
                                'id' => 'id-perangkat',
                                'value' => $perangkat['id'],
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
                                    if (empty($perangkat['alias'])) {
                                        echo 'Belum Ada Data';

                                    }else{
                                        echo $perangkat['alias'];
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
                                    if (empty($perangkat['latitude']) AND empty($perangkat['longitude'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $perangkat['latitude'] .','. $perangkat['longitude'];
                                    }
                                    ?>
                                    </h4>
                                </center>
                                <hr style="border:0.5px solid #4F7BC3;">
                                <h4 class="text-center">
                                <?php
                                    if (empty($data['tgl'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $data['tgl'];
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <p class="text-center">Arah Angin</p>
                                            <h3>
                                            <?php
                                                if (empty($arangin['arah_angin'])){
                                                    echo 'null';
                                                }else{
                                                    if ($arangin['arah_angin'] == 'W') {
                                                        echo 'Barat';
                                                    }elseif ($arangin['arah_angin'] == 'S') {
                                                        echo 'Selatan';
                                                    }elseif ($arangin['arah_angin'] == 'N') {
                                                        echo 'Utara';
                                                    }elseif ($arangin['arah_angin'] == 'E') {
                                                        echo 'Timur';
                                                    }elseif ($arangin['arah_angin'] == 'SE') {
                                                        echo 'Tenggara';
                                                    }elseif ($arangin['arah_angin'] == 'SW') {
                                                        echo 'Barat Daya';
                                                    }elseif ($arangin['arah_angin'] == 'NW') {
                                                        echo 'Barat Laut';
                                                    }elseif ($arangin['arah_angin'] == 'NE') {
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
                                <div class="col-md-6">
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <p class="text-center">Kelembaban</p>
                                            <h3>
                                            <?php
                                                if (empty($kelembaban['kelembaban'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($kelembaban['kelembaban'])) ;
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Curah Hujan</p>
                                            <h3>
                                            <?php
                                                if (empty($curjan['curah_hujan'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($curjan['curah_hujan'])) ;
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
                                <div class="col-md-6">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <p class="text-center">Kecepatan Angin</p>
                                            <h3>
                                            <?php
                                                if (empty($kangin['kecepatan_angin'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($kangin['kecepatan_angin'])) ;
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
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="pad box-pane-right bg-green text-center" id="hov-here">
                                <p class="text-center">Temperature</p>
                                <div class="icon" style="max-height:100px;">
                                    <i class="ion-ios-thermometer big" id="hov-lah"></i>
                                </div>
                                <h3>
                                <?php
                                    if (empty($suhu['suhu'])) {
                                        echo '0';
                                    }else{
                                        echo (round($suhu['suhu'])) ;
                                    }
                                ?>
                                    &deg;
                                </h3>
                                <h4>Celcius</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (Yii::$app->user->identity->role=='admin') { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Statistik</h3>
                    </div>
                    <div class="box-body">
                        <?php
                            foreach ($chart as $values) {
                                $a[0]= ($values['bulan']); 
                                $c[]= ($values['bulan']); 
                                $b[]= array('type'=> 'column', 'name' =>$values['bulan'], 'data' => array((int)$values['temperature'], 
                                (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'] )); 
                            }
                            echo Highcharts::widget([
                                'options' => [
                                    'title' => ['text' => 'Data Tahun 2018'],
                                    'xAxis' => [
                                        'categories' => ['temperature', 'kelembaban', 'kecepatan_angin','curah_hujan']
                                    ],
                                    'yAxis' => [
                                        'title' => ['text' => 'Jumlah Data']
                                    ],
                                    'series' => $b
                                ]
                            ]);
                        ?>
                    </div>
                    <div class="box-footer">
                        <p class="text-center">
                            <a href="<?=  Url::to(['resume/index']); ?>">Lihat Data Lengkap
                            <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Statistik Suhu</h3>
                    </div>
                    <div class="box-body">
                    <?php
                     foreach( $pie as $pieh){
                        $arah = $pieh['arah_angin'];
                        $jmlh = $pieh['jumlah'];
                        $hasil[] = array($arah, 
                        (int)$jmlh );
                     }
                    ?>
                        <?= Highcharts::widget([
                                'options' => [
                                    'title' => ['text' => 'Data Suhu '],
                                    'plotOptions' => [
                                        'pie' => [
                                            'cursor' => 'pointer',
                                        ],
                                    ],
                                    'series' => [
                                        [ 
                                            'type' => 'pie',
                                            'name' => 'Elements',
                                            'data' => $hasil,
                                        ] 
                                    ],
                                ],
                            ]);
                        ?>
                    </div>
                    <div class="box-footer">
                        <p class="text-center">
                            <a href="<?=  Url::to(['resume/index']); ?>">Lihat Data Lengkap
                            <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning collapsed-box">
                <div class="box-header with-border">
                    <center>
                        <h3 class="box-title" id="ls">Lihat Selengkapnya</h3>
                    </center>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
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