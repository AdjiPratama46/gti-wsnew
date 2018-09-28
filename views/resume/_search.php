<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Perangkat;
use kartik\date\DatePicker;

$perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias')
?>
<div class="resume-search">
    <div class="row">
        <div class="col-md-3 col-md-offset-6">
            <?= Select2::widget([
                'name' => 'Luy',
                'data' => $perangkats,
                'options' => ['placeholder' => 'Pilih Perangkat'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
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