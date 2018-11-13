<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\Data;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;

if (Yii::$app->user->identity->role=="admin") {
    $query = 'SELECT * FROM perangkat,data WHERE perangkat.id=data.id_perangkat';
    $perangkats = ArrayHelper::map(Data::findBySql($query)->all(),'perangkat.id','perangkat.alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data GROUP BY tgl ORDER BY tgl DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}elseif (Yii::$app->user->identity->role=="user") {
    $id = Yii::$app->user->identity->id;
    $perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.$id.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}


?>
<div class="resume-search">
    <div class="row">
        <div class="col-md-3">
            <?= ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'target'=> ExportMenu::TARGET_POPUP,
                    'dropdownOptions' => [
                        'label' => 'Export',
                        'class' => 'btn ',
                        'style' => 'border-radius:0;'
                    ],
                    'columnSelectorOptions' => [
                        'label' => 'Kolom',
                        'class' => 'btn',
                        'style' => 'visibility: hidden;width:0;height:0;position:absolute;'
                    ],
                    'exportConfig' => [
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => [
                                'alertMsg' => 'Tabel data resume akan di export menjadi file CSV',
                            ],
                            ExportMenu::FORMAT_TEXT => [
                                'alertMsg' => 'Tabel data resume akan di export menjadi file TEXT',
                            ],
                            ExportMenu::FORMAT_PDF => [
                                'alertMsg' => 'Tabel data resume akan di export menjadi file PDF',
                            ],
                            ExportMenu::FORMAT_EXCEL => [
                                'alertMsg' => 'Tabel data resume akan di export menjadi file EXCEL 95+',
                            ],
                            ExportMenu::FORMAT_EXCEL_X => [
                                'alertMsg' => 'Tabel data resume akan di export menjadi file EXCEL 2007+',
                            ],
                        ],
                    'filename' => date('YmdHis', mktime(date('H')+5)).'_WSDataResume',
                    'messages' => [
                        'allowPopups' =>  '',
                        'confirmDownload' => 'Lanjutkan proses export ?',
                        'downloadProgress' => 'Memproses file. silahkan tunggu...',
                        'downloadComplete' => 'Download selesai.'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-3 col-md-offset-3">
            <?= Select2::widget([
                'name' => 'id-perangkat',
                'id' => 'id-perangkat',
                'value' => $model['id'],
                'data' => $perangkats,
                'options' => ['placeholder' => 'Pilih Perangkat'],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= Select2::widget([
                'name' => 'id-tahun',
                'id' => 'id-tahun',
                'value' => date('Y'),
                'data' => $years,
                'options' => ['placeholder' => 'Pilih Tahun'],
            ]); ?>
        </div>
    </div>
</div>

<?php
$urlData = Url::to(['resume/get']);
$urlDate = Url::to(['resume/date']);
$this->registerJs(
    "
    $('#id-perangkat').change(function(){
        var id = $('#id-perangkat').val();
        var date = $('#id-tahun').val();
        $.ajax({
            type :'GET',
            url : '{$urlData}',
            data:'id='+id+'&tgl='+date,
            success : function(data){
                $('#tabel').html(data);
            }
        });
    });
    $('#id-tahun').change(function(){
        var id = $('#id-perangkat').val();
        var date = $('#id-tahun').val();
        $.ajax({
            type :'GET',
            url : '{$urlDate}',
            data:'id='+id+'&tgl='+date,
            success : function(data){
                $('#tabel').html(data);
            }
        });
    });
    "
);

?>
