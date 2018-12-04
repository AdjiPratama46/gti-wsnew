<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use kartik\date\DatePicker;

$urlC = Url::to(['site/charthari']);
$urlCA = Url::to(['site/chart']);
$perangkatid = $query['id_perangkat'];
if (empty($perangkatid)) {
    $perangkatid = $id;
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
<div id="crot4">
    <?php
        $timestamps = strtotime($id);
        $new_date = date('d F Y', $timestamps);
        $hari = date('D',$timestamps);
        if ($hari == 'Mon') {
            $dinten = str_replace('Mon','Senin',$hari);
        }elseif ($hari == 'Tue') {
            $dinten = str_replace('Tue','Selasa',$hari);
        }elseif ($hari == 'Wed') {
            $dinten = str_replace('Wed','Rabu',$hari);
        }elseif ($hari == 'Thu') {
            $dinten = str_replace('Thu','Kamis',$hari);
        }elseif ($hari == 'Fri') {
            $dinten = str_replace('Fri','Jumat',$hari);
        }elseif ($hari == 'Sat') {                   
            $dinten = str_replace('Sat','Sabtu',$hari);
        }elseif ($hari == 'Sun') {
            $dinten = str_replace('Sun','Minggu',$hari);
        } 
        if (empty($charthari) || empty($piehari)) { ?>
            <div class="col-md-12">
                <h4 class="text-center">Belum Ada Data Pada Hari <?= $dinten.", ".$new_date ?>. Silahkan Pilih Waktu Lain</h4>
            </div>
        <?php }else { ?>
            <div class="col-md-12" id="c">
                <?php
                    foreach ($charthari as $values) {
                        $a[0]= ($values['waktu']);
                        $c[]= ($values['waktu']);
                        $b[]= array('type'=> 'column', 'name' =>$values['waktu'], 'data' => array((int)$values['temperature'],
                        (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
                    }
          			if(date('d F Y', mktime(0, 0, 0, date('m'), date('d') -1, date('Y')))==$new_date){
                      $judul='Data Hari Kemarin';
                      $judul1='Data Arah Angin Hari Kemarin';
                    }else{
                      $judul='Data Hari '.$dinten.",".$new_date;
                      $judul1='Data Arah Angin Hari '.$dinten.",".$new_date;
                    }
                    echo Highcharts::widget([
                        'options' => [
                      		'credits' => ['enabled' => false],
                            'chart' => ['renderTo'=> 'c'],
                            'title' => ['text' => $judul],
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
          <br>
    <br><hr style="border:0.5px solid #00C0EF;width:60%;"><br>
        </div>
            <div class="col-md-12" id="b">
              
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
                      		'credits' => ['enabled' => false],
                            'chart' => ['type' => 'pie', 'renderTo' => 'b',
                                'options3d'=>[
                                    'enabled'=>true,
                                    'alpha'=>45,
                                    'beta'=>0,
                                ]
                            ],
                            'title' => ['text' => $judul1],
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
        <?php }
    ?>
    
</div>