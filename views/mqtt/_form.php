<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use borales\extensions\phoneInput\PhoneInput;

$jam =array(
      60 => '1 jam' ,
      120 => '2 jam' ,
      180 => '3 jam' ,
      240 => '4 jam' ,
      300 => '5 jam' ,
      360 => '6 jam' ,
      420 => '7 jam' ,
      480 => '8 jam' ,
      540 => '9 jam' ,
      600 => '10 jam' ,
      660 => '11 jam' ,
      720 => '12 jam' ,
      780 => '13 jam' ,
      840 => '14 jam' ,
      900 => '15 jam' ,
      960 => '16 jam' ,
      1020 => '17 jam' ,
      1080 => '18 jam' ,
      1140 => '19 jam' ,
      1200 => '20 jam' ,
      1260 => '21 jam' ,
      1320 => '22 jam' ,
      1380 => '23 jam' ,
      1440 => '24 jam'
    );

?>

<div class="konfigurasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'interval', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-5'>{input}</div>{hint}{error}</div>"])
        ->widget(Select2::classname(), [
            'name' => 'frekuensi',
            'id' => 'frekuensi',
            'data' => $jam,
            'pluginOptions' => [
                'placeholder' =>'Pilih jam',
                'clearBtn' => true,
            ],
            'options' => ['value'=> $mdl->interval]
        ])
    ?>

    <?= $form->field($model, 'ip_server', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-5'>{input}</div>{hint}{error}</div>"])
        ->textInput(['maxlength' => true, 'value' => $mdl->ip_server])
    ?>

    <?= $form->field($model, 'no_hp', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-5'>{input}</div>{hint}{error}</div>"])
        ->textInput(['maxlength' => true, 'value' => $mdl->no_hp])
    ?>

    <?= $form->field($model, 'gsm_to', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-4'>{input}</div><div class='col-md-1'><label>Menit</label></div>{hint}{error}</div>"])
        ->textInput(['maxlength' => true, 'value' => $mdl->gsm_to])
    ?>

    <?= $form->field($model, 'gps_to', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-4'>{input}</div><div class='col-md-1'><label>Menit</label></div>{hint}{error}</div>"])
        ->textInput(['maxlength' => true, 'value' => $mdl->gps_to])
    ?>

    <?= $form->field($model, 'ussd_code', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-5'>{input}</div>{hint}{error}</div>"])
        ->textInput(['maxlength' => true, 'value' => $mdl->ussd_code])
    ?>

    <div class="form-group">
        <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
