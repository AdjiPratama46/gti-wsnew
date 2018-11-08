<?php
use miloschuman\highcharts\Highcharts;
?>
<div class="row" id="cp">
    <?php
        if (empty($charthari) || empty($piehari)) { ?>
            <div class="col-md-12">
                <h3 class="text-center">Belum Ada Data</h3>
            </div>
        <?php }else { ?>
            <div class="col-md-7">
                <?php 
                    foreach ($charthari as $values) {
                        $a[0]= ($values['hari']);
                        $c[]= ($values['hari']);
                        $b[]= array('type'=> 'column', 'name' =>$values['hari'], 'data' => array((int)$values['temperature'],
                        (int)$values['kelembaban'],(int)$values['kecepatan_angin'],(int)$values['curah_hujan'],(int)$values['tekanan_udara'] ));
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
                            'series' => $b
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-5">
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
                        'title' => ['text' => 'Data Arah Angin Minggu Ini'],
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
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-orange" id="bct" name="temperature">Temperature</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-maroon" id="bck" name="kelembaban">Kelembaban</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-purple" id="bcka" name="kecepatan_angin">Kecepatan Angin</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-black" id="bcu" name="curah_hujan">Curah Hujan</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-xs bg-navy" id="btu" name="tekanan_udara">Tekanan Udara</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-xs btn-success" id="bc" name="all">
                    All
                </button>
            </div>
        </div>
    <?php } ?>
</div>










                        