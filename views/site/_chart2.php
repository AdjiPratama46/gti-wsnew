<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);

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

?>
<div id="crot2">
   <?php
   echo 'comming soon';
         if ($id == 'all') {
             foreach ($chart as $values) {
                 $a[0]= ($values['minggu']);
                 $c[]= ($values['minggu']);
                 $b[]= array('type'=> 'column', 'name' =>$values['minggu'], 'data' => array((int)$values['temperature'],
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
         }else {
             foreach ($chart as $values) {
                 $b[] = (int)$values[$id];
                 $c[] = $values['minggu'];
             }
             echo Highcharts::widget([
               'options' => [
                     'chart' => ['type' => 'line','renderTo'=> 'crot2'],
                     'title' => ['text' => 'Data '.$name.' Bulan Ini'],
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
</div>
