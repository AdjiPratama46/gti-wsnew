<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Perangkat;
use kartik\date\DatePicker;

$perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias')
?>
<div class="resume-search">
    <div class="row">
        <div class="col-md-3 col-md-offset-6">
            <?= Select2::widget([
                'name' => 'id-perangkat',
                'id' => 'id-perangkat',
                'data' => $perangkats,
                'options' => ['placeholder' => 'Pilih Perangkat'],
            ]); ?>
        </div>
        <div class="col-md-3">
            <?= DatePicker::widget([
                'name' => 'date_1',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy'
                ], 
            ]); ?>
        </div>        
    </div>
</div>

<?php
$urlData = Url::to(['resume/get']);
$this->registerJs("$('#id-perangkat').change(function(){
    var id = $('#id-perangkat').val();    
    $.ajax({
        type :'GET',
        url : '{$urlData}',
        data:'id='+id,
        success : function(data){
            $('#tabel').html(data);
         }
    });
});");

?>