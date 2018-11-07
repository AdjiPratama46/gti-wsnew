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
if(Yii::$app->user->identity->role=='admin'){
  $sql = 'SELECT perangkat.id,data.id_perangkat FROM perangkat,data WHERE
  perangkat.id=data.id_perangkat AND DATE(data.tgl)= DATE(NOW())-1' ;

}
else{
  $sql = 'SELECT perangkat.id,data.id_perangkat FROM perangkat,data WHERE
  perangkat.id=data.id_perangkat AND DATE(data.tgl)= DATE(NOW())-1 AND perangkat.id_owner ="'.Yii::$app->user->identity->id.'" ';
}

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
    $('#bc').click(function(){
        var id = $('#bc').attr('name');
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#ch').html(data);
            }
        });
    });
    $('#bct').click(function(){
        var id = $('#bct').attr('name');
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#ch').html(data);
            }
        });
    });
    $('#bck').click(function(){
        var id = $('#bck').attr('name');
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#ch').html(data);
            }
        });
    });
    $('#bcu').click(function(){
        var id = $('#bcu').attr('name');
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#ch').html(data);
            }
        });
    });
    $('#bcka').click(function(){
        var id = $('#bcka').attr('name');
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#ch').html(data);
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
                    <!-- <div class="small-box bg-aqua"> <div class="inner"> <h3></h3> <p>Jumlah
                    User</p> </div> <div class="icon"> <i class="ion ion-ios-people"></i> </div> <a
                    href="#" class="small-box-footer">Lihat Lainnya <i class="fa
                    fa-arrow-circle-right"></i></a> </div> -->
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

    <?php
    }
    ?>

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
                                        $new_date = date('d-m-Y', $timestamps);
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
    <?php
    if (Yii::$app->user->identity->role=='admin') { ?>
    <div class="row">
        <div class="col-md-7">
            <div class="box  box-solid box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Statistik</h3>
                </div>
                <div class="box-body" id="ch">
                    <?php
                            foreach ($chart as $values) {
                                $a[0]= ($values['bulan']);
                                $c[]= ($values['bulan']);
                                $b[]= array('type'=> 'column', 'name' =>$values['bulan'], 'data' => array((int)$values['temperature'],
                                (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
                            }
                            echo Highcharts::widget([
                                'options' => [
                                    'title' => ['text' => 'Data Tahun 2018'],
                                    'xAxis' => [
                                        'categories' => ['Temperature', 'Kelembaban', 'Kecepatan Angin','Curah Hujan','Tekanan Udara']
                                    ],
                                    'yAxis' => [
                                        'title' => ['text' => 'Jumlah Data']
                                    ],
                                    'series' => $b
                                ]
                            ]);
                        ?>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-block btn-xs bg-orange" id="bct" name="temperature">Temperature</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-block btn-xs bg-maroon" id="bck" name="kelembaban">Kelembaban</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-block btn-xs bg-purple" id="bcka" name="kecepatan_angin">Kecepatan Angin</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-block btn-xs bg-black" id="bcu" name="curah_hujan">Curah Hujan</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-block btn-xs bg-navy" id="btu" name="tekanan_udara">Tekanan Udara</button>
                        </div>
                        <div class="col-md-4">
                            <button
                                type="button"
                                class="btn btn-block btn-xs btn-success"
                                id="bc"
                                name="all">
                                All
                            </button>
                        </div>
                    </div>
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
        <div class="col-md-5">
            <div class="box box-solid box-danger" id="bx-dg">
                <div class="box-header with-border">
                    <h3 class="box-title">Statistik Arah Angin</h3>
                </div>
                <div class="box-body" id="bx-dg">
                    <?php
                     foreach( $pie as $pieh){
                        $arah = $pieh['arah_angin'];
                        $jmlh = $pieh['jumlah'];
                        $hasil[] = array($arah,
                        (int)$jmlh );
                     }
                    ?>
                    <?= Highcharts::widget([
                            'scripts' => [
                                'highcharts-3d',
                             ],
                                'options' => [
                                    'chart' => ['type' => 'pie',
                                        'options3d'=>[
                                            'enabled'=>true,
                                            'alpha'=>45,
                                            'beta'=>0,
                                        ]
                                    ],
                                    'title' => ['text' => 'Data Arah Angin Tahun 2018 '],
                                    'plotOptions' => [
                                        'pie' => [
                                            'cursor' => 'pointer',
                                            'allowPointSelect' => true,
                                            'depth'=> 35,
                                            'dataLabels' => [
                                                'enabled' => true,
                                            ],
                                            'showInLegend' => true
                                        ],

                                    ],
                                    'series' => [
                                        [
                                            'data' => $hasil,
                                            'name' => 'Jumlah'
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
