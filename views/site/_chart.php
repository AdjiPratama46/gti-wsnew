<?php
use miloschuman\highcharts\Highcharts;

?>

<div class="box-body" id="ch">
    <?php
    if ($id =='kelembaban') {
        foreach ($chart as $values) {
            $b[] = (int)$values['kelembaban']; 
            $c[] = $values['bulan'];
        }
        echo Highcharts::widget([
            'options' => [
                'chart' => ['type' => 'line'],
                'title' => ['text' => 'Data Kelembaban Tahun 2018'],
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
                    'name' =>  'Kelembaban'
                    ]
                ]
            ]
        ]);
    }else {
        echo 'coming soon';
    }
        
    ?>
</div>