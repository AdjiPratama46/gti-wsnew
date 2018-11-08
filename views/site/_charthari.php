<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlCh = Url::to(['site/charthari']);
$this->registerJs("
$('#bc1').click(function(){
    var id = $('#bc1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
$('#bct1').click(function(){
    var id = $('#bct1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
$('#bck1').click(function(){
    var id = $('#bck1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
$('#bcu1').click(function(){
    var id = $('#bcu1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
$('#bcka1').click(function(){
    var id = $('#bcka1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
$('#btu1').click(function(){
    var id = $('#btu1').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlCh}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch1').html(data);
        }
    });
});
    ");
?>

<div class="box-body" id="ch1">
    <?php
    if ($id == 'temperature') {
        $name = 'Temperature';
    }elseif ($id == 'kelembaban') {
        $name = 'Kelembaban';
    }elseif ($id == 'kecepatan_angin') {
        $name = 'Kecepatan Angin';
    }elseif ($id == 'curah_hujan') {
        $name = 'Curah Hujan';
    }elseif ($id == 'tekanan_udara') {
        $name = 'Tekanan Udara';
    }
    if ($id == 'all') {
        foreach ($charthari as $values1) {
            $a1[0]= ($values1['hari']);
            $c1[]= ($values1['hari']);
            $b1[]= array('type'=> 'column', 'name' =>$values1['hari'], 'data' => array((int)$values1['temperature'],
            (int)$values1['kelembaban'],(int)$values1['kecepatan_angin'],(int)$values1['curah_hujan'],(int)$values1['tekanan_udara'] ));
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
                'series' => $b1
            ]
        ]);
    }else {
        foreach ($charthari as $values1) {
            $b1[] = (int)$values1[$id];
            $c1[] = $values1['hari'];
        }
        echo Highcharts::widget([
            'options' => [
                'chart' => ['type' => 'line'],
                'title' => ['text' => 'Data '.$name.' Minggu Ini'],
                'xAxis' => [
                    'categories' =>$c1
                ],
                'yAxis' => [
                    'title' => ['text' => 'Jumlah']
                ],
                'plotOptions' => [
                    'line' =>  [
                        'dataLabels' =>  [
                          'enabled' =>  true
                        ],
                        'enableMouseTracking' =>  false
                    ]
                ],
                'series' => [[
                    'data' => $b1,
                    'name' =>  $name
                    ]
                ]
            ]
        ]);
    }
    ?>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-block btn-xs bg-orange" id="bct1" name="temperature">Temperature</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-block btn-xs bg-maroon" id="bck1" name="kelembaban">Kelembaban</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-block btn-xs bg-purple" id="bcka1" name="kecepatan_angin">Kecepatan Angin</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-block btn-xs bg-black" id="bcu1" name="curah_hujan">Curah Hujan</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-block btn-xs bg-navy" id="btu1" name="tekanan_udara">Tekanan Udara</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-block btn-xs btn-success" id="bc1" name="all">
                All
            </button>
        </div>
    </div>
</div>
