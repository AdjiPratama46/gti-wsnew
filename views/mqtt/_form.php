<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\time\TimePicker;
//use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Konfigurasi */
/* @var $form yii\widgets\ActiveForm */

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

    $jam1 =array(
          '00' => '0 jam' ,
          '01' => '1 jam' ,
          '02' => '2 jam' ,
          '03' => '3 jam' ,
          '04' => '4 jam' ,
          '05' => '5 jam' ,
          '06' => '6 jam' ,
          '07' => '7 jam' ,
          '08' => '8 jam' ,
          '09' => '9 jam' ,
          '10' => '10 jam' ,
          '11' => '11 jam' ,
          '12' => '12 jam' ,
          '13' => '13 jam' ,
          '14' => '14 jam' ,
          '15' => '15 jam' ,
          '16' => '16 jam' ,
          '17' => '17 jam' ,
          '18' => '18 jam' ,
          '19' => '19 jam' ,
          '20' => '20 jam' ,
          '21' => '21 jam' ,
          '22' => '22 jam' ,
          '23' => '23 jam' ,
          '24' => '24 jam'
        );

    $menit=array(
        '00' => '0 menit' ,
        '05' => '5 menit' ,
        '10' => '10 menit' ,
        '15' => '15 menit' ,
        '20' => '20 menit' ,
        '25' => '25 menit' ,
        '30' => '30 menit' ,
        '35' => '35 menit' ,
        '40' => '40 menit' ,
        '45' => '45 menit' ,
        '50' => '50 menit' ,
        '55' => '55 menit' ,

    );

?>

<div class="konfigurasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?php /*$form->field($model, 'frekuensi', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->widget(TimePicker::className(),[
    'name' => 'start_time',

    'pluginOptions' => [
        'showSeconds' => false,
        'showMeridian' => false,
        'secondStep' => 60

    ]
]) */?>


      <?= $form->field($model, 'frekuensi', [
        'template' => "
          <div class='row'>
            <div class='col-md-4' align='right'>{label}</div>
            <div class='col-md-5'>{input}</div>{hint}{error}
          </div>"])->widget(Select2::classname(), [
            'name' => 'frekuensi',
            'id' => 'frekuensi',

            'data' => $jam,

            'pluginOptions' => [
                'placeholder' =>'Pilih jam',
                'clearBtn' => true,
            ],
            'options' => [
              'value'=> $mdl->frekuensi,
            ]

    ]) ?>





    <?= $form->field($model, 'ip_server', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-5'>{input}</div>{hint}{error}
        </div>"])->textInput(['maxlength' => true, 'value' => $mdl->ip_server]) ?>

        <?= $form->field($model, 'no_hp', [
          'template' => "
            <div class='row'>
              <div class='col-md-4' align='right'>{label}</div>
              <div class='col-md-5'>{input}</div>{hint}{error}
            </div>"])->textInput(['maxlength' => true, 'value' => $mdl->no_hp]) ?>

            <?= $form->field($model, 'gsm_to', [
              'template' => "
                <div class='row'>
                  <div class='col-md-4' align='right'>{label}</div>
                  <div class='col-md-5'>{input}</div>{hint}{error}
                </div>"])->textInput(['maxlength' => true, 'value' => $mdl->gsm_to]) ?>

                <?= $form->field($model, 'gps_to', [
                  'template' => "
                    <div class='row'>
                      <div class='col-md-4' align='right'>{label}</div>
                      <div class='col-md-5'>{input}</div>{hint}{error}
                    </div>"])->textInput(['maxlength' => true, 'value' => $mdl->gps_to]) ?>

            <?= $form->field($model, 'ussd_code', [
              'template' => "
                <div class='row'>
                  <div class='col-md-4' align='right'>{label}</div>
                  <div class='col-md-5'>{input}</div>{hint}{error}
                </div>"])->textInput(['maxlength' => true, 'value' => $mdl->ussd_code]) ?>







    <div class="form-group">
        <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
