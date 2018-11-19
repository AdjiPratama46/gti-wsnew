<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;

$urlC = Url::to(['site/chart']);


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
                ?>
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
                            'chart' => ['type' => 'pie', 'renderTo' => 'b',
                                'options3d'=>[
                                    'enabled'=>true,
                                    'alpha'=>45,
                                    'beta'=>0,
                                ]
                            ],
                            'title' => ['text' => 'Data Arah Angin Hari '.$dinten.",".$new_date],
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
