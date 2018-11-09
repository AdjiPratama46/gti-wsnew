<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);
$perangkatid = $query['id_perangkat'];

$this->registerJs("
    $('#mt').click(function(){
        var id = $('#mt').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
    $('#mk').click(function(){
        var id = $('#mk').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
    $('#mka').click(function(){
        var id = $('#mka').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
    $('#mcu').click(function(){
        var id = $('#mcu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
    $('#mtu').click(function(){
        var id = $('#mtu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
    $('#mbc').click(function(){
        var id = $('#mbc').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'minggu';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot3').html(data);
            }
        });
    });
");

?>
<div class="row" id="cp">
    <?php
        if (empty($charthari) || empty($piehari)) { ?>
            <div class="col-md-12">
                <h4 class="text-center">Belum Ada Data Minggu Ini, Silahkan Pilih Perangkat Lain</h4>
            </div>
        <?php }else { ?>
            <div class="col-md-7" id="crot3">
                <?php
                    foreach ($charthari as $values) {
                        $a[0]= ($values['hari']);
                        $c[]= ($values['hari']);
                        $b[]= array('type'=> 'column', 'name' =>$values['hari'], 'data' => array((int)$values['temperature'],
                        (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
                    }
                    echo Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Data Minggu Ini'],
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
                    foreach($piehari as $pieh){
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
                        'title' => ['text' => 'Data Arah Angin Minggu Ini'],
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
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-orange" id="mt" name="temperature">Temperature</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-maroon" id="mk" name="kelembaban">Kelembaban</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-purple" id="mka" name="kecepatan_angin">Kecepatan Angin</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-black" id="mcu" name="curah_hujan">Curah Hujan</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-navy" id="mtu" name="tekanan_udara">Tekanan Udara</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-xs btn-success" id="mbc" name="all">
                    All
                </button>
            </div>
        </div>
    <?php } ?>
</div>
