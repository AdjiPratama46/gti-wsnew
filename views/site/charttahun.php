<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);
$perangkatid = $query['id_perangkat'];

if (Yii::$app->user->identity->role=="user") {
    if (empty($perangkatid)) {
        $perangkatid = $id;
    }
}

$this->registerJs("
    $('#bct').click(function(){
        var id = $('#bct').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
    $('#bck').click(function(){
        var id = $('#bck').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
    $('#bcka').click(function(){
        var id = $('#bcka').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
    $('#bcu').click(function(){
        var id = $('#bcu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
    $('#btu').click(function(){
        var id = $('#btu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
    $('#bc').click(function(){
        var id = $('#bc').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'tahun';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot').html(data);
            }
        });
    });
");
?>
<div class="row" id="cp">
    <?php
        if (empty($chart) || empty($pie)) { ?>
            <div class="col-md-12">
                <h4 class="text-center">Belum Ada Data Tahun Ini, Silahkan Pilih Perangkat Lain</h4>
            </div>
        <?php }else { ?>
            <div class="col-md-7" id="crot">
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
            </div>
            <div class="col-md-5">
                <?php
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
                ?>
            </div>

            <div class="col-md-12">
            <br>
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-block btn-xs bg-orange" id="bct" name="temperature">Temperature</button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-block btn-xs bg-maroon" id="bck" name="kelembaban">Kelembaban</button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-block btn-xs bg-purple" id="bcka" name="kecepatan_angin">Kecepatan Angin</button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-block btn-xs bg-black" id="bcu" name="curah_hujan">Curah Hujan</button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button class="btn btn-block btn-xs bg-navy" id="btu" name="tekanan_udara">Tekanan Udara</button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button type="button" class="btn btn-block btn-xs btn-success" id="bc" name="all">
                        All
                    </button>
                </div>
            </div>
        <?php } ?>
</div>