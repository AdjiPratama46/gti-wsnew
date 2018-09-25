<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                    <?php 
                        if (empty($model->id)) {
                            echo 'Belum Ada Data';
                        }else{
                            echo $model->id;
                        }                        
                        ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="data">
                                <h4>Nama Perangkat :</h4>
                                <h3>
                                <?php 
                                    if (empty($model->alias)) {
                                        echo 'Belum Ada Data';
                                        
                                    }else{
                                        echo $model->alias;
                                    }                        
                                    ?>
                                </h3>
                                <hr style="border:1px solid #4F7BC3;">
                                <h4>Kordinat :</h4>
                                <h3>
                                <?php 
                                    if (empty($model->latitude) AND empty($model->longitude)) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $model->latitude .','. $model->longitude;
                                    }                        
                                    ?>
                                </h3>
                                <hr style="border:1px solid #4F7BC3;">
                                <h3 class="text-center">
                                    <?php 
                                    if (empty($data['tgl'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $data['tgl'];
                                    }                        
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Arah Angin</p>
                                            <h3>
                                                <?php 
                                                if (empty($arangin['arah_angin'])){
                                                    echo '0';
                                                }else{
                                                    echo $arangin['arah_angin'];
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-compass"></i>
                                        </div>
                                        <a href="#data-detail" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Kelembaban</p>
                                            <h3>
                                                <?php 
                                                if (empty($kelembaban['kelembaban'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($kelembaban['kelembaban'])) ;
                                                }
                                                ?>
                                                rh
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-water"></i>
                                        </div>
                                        <a href="#data-detail" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Curah Hujan</p>
                                            <h3>
                                                <?php 
                                                if (empty($curjan['curah_hujan'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($curjan['curah_hujan'])) ;
                                                }
                                                ?>
                                                mm
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-rainy"></i>
                                        </div>
                                        <a href="#data-detail" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Kecepatan Angin</p>
                                            <h3>
                                                <?php 
                                                if (empty($kangin['kecepatan_angin'])) {
                                                    echo '0';
                                                }else{
                                                    echo (round($kangin['kecepatan_angin'])) ;
                                                }
                                                ?>
                                                mph
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-speedometer"></i>
                                        </div>
                                        <a href="#data-detail" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="pad box-pane-right bg-green text-center" style="min-height: 280px">
                                <p class="text-center">Suhu</p>
                                <i class="ion-ios-thermometer big"></i>
                                <h3>
                                <?php 
                                    if (empty($suhu['suhu'])) {
                                        echo '0';
                                    }else{
                                        echo (round($suhu['suhu'])) ;
                                    }
                                ?>
                                &deg;
                                </h3>
                                <h4>Celcius</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box" id="data-detail">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Selengkapnya</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",

                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'tgl:time',
                            'kelembaban',
                            'kecepatan_angin',
                            'arah_angin',
                            'curah_hujan',
                            'temperature',
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>