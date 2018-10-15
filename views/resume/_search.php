<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\Data;
use kartik\date\DatePicker;


if (Yii::$app->user->identity->role=="admin") {
    $query = 'SELECT * FROM perangkat,data WHERE perangkat.id=data.id_perangkat';
    $perangkats = ArrayHelper::map(Data::findBySql($query)->all(),'perangkat.id','perangkat.alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data GROUP BY tgl ORDER BY tgl DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}elseif (Yii::$app->user->identity->role=="user") {
    $perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data WHERE id_perangkat="'.$model['id'].'" GROUP BY tgl ORDER BY tgl DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}
?>
<div class="resume-search">
    <div class="row">
        <div class="col-md-3 col-md-offset-6">
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
