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
<div id="crot3">
   <?php
        if ($id == 'all') {
            foreach ($chart as $values) {
                $a[0]= ($values['hari']);
                $c[]= ($values['hari']);
                $b[]= array('type'=> 'column', 'name' =>$values['hari'], 'data' => array((int)$values['temperature'],
                (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
            }
            echo Highcharts::widget([
                'options' => [
                    'chart' => ['renderTo'=> 'crot3'],
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
        }else {
            foreach ($chart as $values) {
                $b[] = (int)$values[$id];
                $c[] = $values['hari'];
            }
            echo Highcharts::widget([
            'options' => [
                    'chart' => ['type' => 'line','renderTo'=> 'crot3'],
                    'title' => ['text' => 'Data '.$name.' Minggu Ini'],
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
