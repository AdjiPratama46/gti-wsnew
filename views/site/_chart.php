<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);
$this->registerJs("
$('#bc').click(function(){
    var id = $('#bc').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp='$idp,
        success : function(data){
            $('#ch').html(data);
        }
    });
});
$('#bct').click(function(){
    var id = $('#bct').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch').html(data);
        }
    });
});
$('#bck').click(function(){
    var id = $('#bck').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch').html(data);
        }
    });
});
$('#bcu').click(function(){
    var id = $('#bcu').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch').html(data);
        }
    });
});
$('#bcka').click(function(){
    var id = $('#bcka').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp=$idp',
        success : function(data){
            $('#ch').html(data);
        }
    });
});
$('#btu').click(function(){
    var id = $('#btu').attr('name');
    $.ajax({
        type :'GET',
        url : '{$urlC}',
        data:'id='+id+'&idp='$idp,
        success : function(data){
            $('#ch').html(data);
        }
    });
});
    ");
?>

<div class="box-body" id="ch">
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
    }else {
        foreach ($chart as $values) {
            $b[] = (int)$values[$id]; 
            $c[] = $values['bulan'];
        }
        echo Highcharts::widget([
            'options' => [
                'chart' => ['type' => 'line'],
                'title' => ['text' => 'Data '.$name.' Tahun 2018'],
                'xAxis' => [
                    'categories' =>$c
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
                    'data' => $b,
                    'name' =>  $name
                    ]
                ]
            ]
        ]);
    }
    ?>
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
</div>