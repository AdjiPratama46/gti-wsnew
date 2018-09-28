<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Perangkat;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','id');
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box" style="box-shadow:none;">
                <div class="box-header with-border">
                    <h3 class="box-title">
                    <?php
                        if (empty($perangkat['id'])) {
                            echo 'Belum Ada Data';
                        }else{
                            echo $perangkat['id'];
                            // echo Select2::widget([
                            //     'name' => 'id-p',
                            //     'data' => $perangkats,
                            //     'value' => $perangkat['id'],
                            //     'options' => [
                            //         'placeholder' => 'Pilih Id Perangkat',
                            //     ],
                            // ]);
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
                                <center><h4><b>Nama Perangkat</b></h4>
                                <h4>
                                <?php
                                    if (empty($perangkat['alias'])) {
                                        echo 'Belum Ada Data';

                                    }else{
                                        echo $perangkat['alias'];
                                    }
                                    ?>
                                </h4></center>
                                <hr style="border:0.5px solid #4F7BC3;">
                                <center><h4><b>Kordinat</b></h4>
                                <h4>
                                <?php
                                    if (empty($perangkat['latitude']) AND empty($perangkat['longitude'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $perangkat['latitude'] .','. $perangkat['longitude'];
                                    }
                                    ?>
                                </h4></center>
                                <hr style="border:0.5px solid #4F7BC3;">
                                <h4 class="text-center">
                                    <?php
                                    if (empty($data['tgl'])) {
                                        echo 'Belum Ada Data';
                                    }else{
                                        echo $data['tgl'];
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <p class="text-center">Arah Angin</p>
                                            <h3>
                                                <?php
                                                if (empty($arangin['arah_angin'])){
                                                    echo 'null';
                                                }else{
                                                    echo $arangin['arah_angin'];
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-compass"></i>
                                        </div>
                                        <!--<a href="#data-detail" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>-->
                                        <div  class="small-box-footer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-yellow">
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
                                        <div  class="small-box-footer">
                                        </div>
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
                                        <div  class="small-box-footer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-primary">
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
                                        <div  class="small-box-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 " >
                            <div class="pad box-pane-right bg-green text-center" id="hov-here">
                                <p class="text-center">Temperature</p>
                                <div class="icon" style="max-height:100px;">
                                    <i class="ion-ios-thermometer big" id="hov-lah"></i>
                                </div>
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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Selengkapnya</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" >
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'summary' => "Menampilkan <b>{begin}-{end}</b> dari <b id='totaldata'>{totalCount}</b> data",
                        'emptyText' => '<center class="text-danger">Tidak ada data untuk ditampilkan</center>',
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
                <div class="box-footer text-center">
                  <?php echo Html::a('Lihat data lengkap', ['data/index'], ['class' => 'uppercase']); ?>
                </div>
            </div>
        </div>
    </div>

</div>
