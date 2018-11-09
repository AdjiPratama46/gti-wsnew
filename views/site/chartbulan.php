<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);
$perangkatid = $query['id_perangkat'];

$this->registerJs("
    $('#t').click(function(){
        var id = $('#t').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
    $('#k').click(function(){
        var id = $('#k').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
    $('#ka').click(function(){
        var id = $('#ka').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
    $('#cu').click(function(){
        var id = $('#cu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
    $('#tu').click(function(){
        var id = $('#tu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
    $('#a').click(function(){
        var id = $('#a').attr('name');
        var idp = '{$perangkatid}';
        var waktu = 'bulan';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#crot2').html(data);
            }
        });
    });
");
?>
<div class="row" id="cp">
    <?php
        if (empty($chartbulan) || empty($piebulan)) { ?>
            <div class="col-md-12">
                <h4 class="text-center">Belum Ada Data Bulan Ini, Silahkan Pilih Perangkat Lain</h4>
            </div>
        <?php }else { ?>
            <div class="col-md-7" id="crot2">
                <?php
                    foreach ($chartbulan as $values) {
                        $a[0]= ($values['minggu']);
                        $c[]= ($values['minggu']);
                        $b[]= array('type'=> 'column', 'name' =>'Minggu Ke-'.$values['minggu'], 'data' => array((int)$values['temperature'],
                        (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
                    }
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => ['renderTo'=> 'crot2'],
                            'title' => ['text' => 'Data Bulan Ini'],
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
                    foreach($piebulan as $pieh){
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
                        'title' => ['text' => 'Data Arah Angin Bulan Ini'],
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
                <button class="btn btn-block btn-xs bg-orange" id="t" name="temperature">Temperature</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-maroon" id="k" name="kelembaban">Kelembaban</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-purple" id="ka" name="kecepatan_angin">Kecepatan Angin</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-black" id="cu" name="curah_hujan">Curah Hujan</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-navy" id="tu" name="tekanan_udara">Tekanan Udara</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-xs btn-success" id="a" name="all">
                    All
                </button>
            </div>
        </div>
    <?php } ?>
</div>
