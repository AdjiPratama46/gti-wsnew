<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Dashboard</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Perangkat</strong>
                            </p>
                            <div class="chart">
                                <h4>Nama Perangkat :</h4>
                                <h3>NULL</h3>
                                <hr style="border:1px solid #4F7BC3;">
                                <h4>Kordinat :</h4>
                                <h3>NULL</h3>
                                <hr style="border:1px solid #4F7BC3;">
                                <h3 class="text-center"><?= date('Y-m-d'); ?></h3>
                                <div id="MyClockDisplay" class="clock text-center"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="text-center">
                                <strong>Data</strong>
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Arah Angin</p>
                                            <h3>NULL</h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-compass"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Kelembaban</p>
                                            <h3>NULL</h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-water"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info
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
                                            <h3>NULL</h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-rainy"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <p class="text-center">Kecepatan Angin</p>
                                            <h3>NULL</h3>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-ios-speedometer"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p class="text-center">
                                <strong>Suhu</strong>
                            </p>
                            <div class="pad box-pane-right bg-green text-center" style="min-height: 280px">
                                <i class="ion-ios-thermometer big"></i>
                                <h2>NULL</h2>
                                <h3>Celcius</h3>
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
                    <h3 class="box-title">Lihat Selengkapnya</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body"></div>
            </div>
        </div>
    </div>

</div>
<?php
$js = <<<js
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
    
    setTimeout(showTime, 1000);
}
showTime();
js;

$this->registerJs($js);

?>