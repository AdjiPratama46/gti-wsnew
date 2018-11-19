<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use kartik\date\DatePicker;

$urlC = Url::to(['site/charthari']);
$urlCA = Url::to(['site/chart']);
$perangkatid = $query['id_perangkat'];
if (Yii::$app->user->identity->role=="user") {
    if (empty($perangkatid)) {
        $perangkatid = $id;
    }
}
 $this->registerJs("
    $('#dp1').change(function(){
        var id = $('#dp1').val();
        var idp = '{$perangkatid}';
        $.ajax({
            type :'GET',
            url : '{$urlC}',
            data:'id='+id+'&idp='+idp,
            success : function(data){
                $('#crot4').html(data);
            }
        });
    });
    $('#ht').click(function(){
        var id = $('#ht').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
    $('#hk').click(function(){
        var id = $('#hk').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
    $('#hka').click(function(){
        var id = $('#hka').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
    $('#hcu').click(function(){
        var id = $('#hcu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
    $('#htu').click(function(){
        var id = $('#tu').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
    $('#hbc').click(function(){
        var id = $('#hbc').attr('name');
        var idp = '{$perangkatid}';
        var waktu = $('#dp1').val();
        $.ajax({
            type :'GET',
            url : '{$urlCA}',
            data:'id='+id+'&idp='+idp+'&waktu='+waktu,
            success : function(data){
                $('#c').html(data);
            }
        });
    });
");
?>
<div class="row" id="cp">
    <?php
        if (empty($charthari) || empty($piehari)) { ?>
            <div class="col-md-12">
                <h4 class="text-center">Belum Ada Data Harian, Silahkan Pilih Perangkat Lain</h4>
            </div>
        <?php }else { ?>
            <div class="col-sm-3 col-sm-offset-9">
                <?= DatePicker::widget([
                        'name' => 'dp',
                        'id' => 'dp1',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'layout' => '{picker}{input}',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
                <hr>
            </div>
        <div id="crot4">
            <div class="col-md-7" id="c">
                <?php
                    foreach ($charthari as $values) {
                        $a[0]= ($values['waktu']);
                        $c[]= ($values['waktu']);
                        $b[]= array('type'=> 'column', 'name' =>$values['waktu'], 'data' => array((int)$values['temperature'],
                        (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
                    }
                    echo Highcharts::widget([
                        'options' => [
                            'title' => ['text' => 'Data Hari Kemarin'],
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
            <div class="col-md-5" id="b">
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
                            'title' => ['text' => 'Data Arah Angin Hari Kemarin'],
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
        </div>
        <div class="col-md-12">
            <br>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-orange" id="ht" name="temperature">Temperature</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-maroon" id="hk" name="kelembaban">Kelembaban</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-purple" id="hka" name="kecepatan_angin">Kecepatan Angin</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-black" id="hcu" name="curah_hujan">Curah Hujan</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-navy" id="htu" name="tekanan_udara">Tekanan Udara</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-xs btn-success" id="hbc" name="all">
                    All
                </button>
            </div>
        </div>
    <?php } ?>
</div>
