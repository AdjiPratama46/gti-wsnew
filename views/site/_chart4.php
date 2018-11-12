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
<div id="c">
<?php
$timestamps = strtotime($waktu);
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
    if ($id == 'all' && empty($waktu)) {
            foreach ($chart as $values) {
                $a[0]= ($values['waktu']);
                $c[]= ($values['waktu']);
                $b[]= array('type'=> 'column', 'name' =>$values['waktu'], 'data' => array((int)$values['temperature'],
                (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
            }
            echo Highcharts::widget([
                'options' => [
                    'chart' => ['renderTo'=> 'c'],
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
        }elseif(empty($waktu)) {
            foreach ($chart as $values) {
                $b[] = (int)$values[$id];
                $c[] = $values['waktu'];
            }
            echo Highcharts::widget([
            'options' => [
                    'chart' => ['type' => 'line','renderTo'=> 'c'],
                    'title' => ['text' => 'Data '.$name.' Hari Kemarin'],
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
        }if ($id == 'all' && !empty($waktu)) {
            foreach ($chart as $values) {
                $a[0]= ($values['waktu']);
                $c[]= ($values['waktu']);
                $b[]= array('type'=> 'column', 'name' =>$values['waktu'], 'data' => array((int)$values['temperature'],
                (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
            }
            echo Highcharts::widget([
                'options' => [
                    'chart' => ['renderTo'=> 'c'],
                    'title' => ['text' => 'Data Hari '.$dinten.",".$new_date],
                    'xAxis' => [
                        'categories' => ['Temperature', 'Kelembaban', 'Kecepatan Angin','Curah Hujan','Tekanan Udara']
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'Jumlah Data']
                    ],
                    'series' => $b
                ]
            ]);
        }elseif(!empty($waktu)) {
            foreach ($chart as $values) {
                $b[] = (int)$values[$id];
                $c[] = $values['waktu'];
            }
            echo Highcharts::widget([
            'options' => [
                    'chart' => ['type' => 'line','renderTo'=> 'c'],
                    'title' => ['text' => 'Data '.$name.' Hari '.$dinten.",".$new_date],
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
