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
$urlC = Url::to(['site/chart']);
$perangkatid = $perangkat['id'];
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
$this->registerJs("
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
    $('#btu').click(function(){
        var id = $('#btu').attr('name');
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
    $('#bx-tl').on('click ', function (event) {
        $('#bx-bd').slideDown(500);
        if ($('#ls').text()=='Lihat Selengkapnya') {
            $('#ls').text('Sembunyikan');
        }else{
            $('#bx-bd').slideUp(500);
            $('#ls').text('Lihat Selengkapnya');
        }
    })
    ");
?>
<div class="site-index-user" id="tabel">

    <!-- box detail -->
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
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <p class="text-center">Temperature</p>
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="small-box bg-maroon">
                                        <div class="inner">
                                            <p class="text-center">Tekanan Udara</p>
                                            <h3>
                                            <?php
                                                if (empty($teud['tekanan_udara'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($teud['tekanan_udara'])) ;
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

    <!-- chart -->
    <div class="row">
        <div class="col-md-7">
            <div class="box box-solid box-success">
                <div class="box-header">
                    <h3 class="box-title">Statistik</h3>
                </div>
                <?php
                    if (empty($chart)) { ?>
                        <h4 style="padding:5px;">Belum Ada Data</h4>
                    <?php }else { ?>
                        <div class="box-body" id="ch">
                    <?php
                        if ($chart != null) {
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
                            <button type="button" class="btn btn-block btn-xs btn-success" id="bc" name="all">
                                    All
                            </button>
                        </div>
                    </div>
                    <?php
                        }  
                    ?>
                </div>
                <div class="box-footer">
                    <p class="text-center">
                        <a href="<?=  Url::to(['resume/index']); ?>">Lihat Data Lengkap
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </p>
                </div>
                <?php    }
                ?>
                
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-solid box-danger" id="bx-dg">
                <div class="box-header">
                    <h3 class="box-title">Statistik Arah Angin</h3>
                </div>
                <?php if (empty($chart)) { ?>
                        <h4 style="padding:5px;">Belum Ada Data</h4>
                        <style>
                        #bx-dg{
                            padding-bottom:0px;
                        }
                        </style>
                <?php }else { ?>
                <div class="box-body">
                    <?php
                        if ($pie != null) {
                            foreach( $pie as $pieh){
                                $arah = $pieh['arah_angin'];
                                $jmlh = $pieh['jumlah'];
                                $hasil[] = array($arah, 
                                (int)$jmlh );
                            }
                            echo Highcharts::widget([
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
                        }else {
                            echo 'Belum Ada Data';
                        }
                     
                    ?>
                </div>
                <div class="box-footer">
                    <p class="text-center">
                        <a href="<?=  Url::to(['resume/index']); ?>">Lihat Data Lengkap
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- gridview -->
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
                            data-widget="collapse">
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
                </div>
                <div class="box-footer text-center" id="myBox">
                    <?php echo Html::a('Lihat Data Lengkap', ['data/index']); ?>
                </div>
            </div>
        </div>
    </div>
</div>