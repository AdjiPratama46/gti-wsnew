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
      '01:00:00' => '1 jam' ,
      '02:00:00' => '2 jam' ,
      '03:00:00' => '3 jam' ,
      '04:00:00' => '4 jam' ,
      '05:00:00' => '5 jam' ,
      '06:00:00' => '6 jam' ,
      '07:00:00' => '7 jam' ,
      '08:00:00' => '8 jam' ,
      '09:00:00' => '9 jam' ,
      '10:00:00' => '10 jam' ,
      '11:00:00' => '11 jam' ,
      '12:00:00' => '12 jam' ,
      '13:00:00' => '13 jam' ,
      '14:00:00' => '14 jam' ,
      '15:00:00' => '15 jam' ,
      '16:00:00' => '16 jam' ,
      '17:00:00' => '17 jam' ,
      '18:00:00' => '18 jam' ,
      '19:00:00' => '19 jam' ,
      '20:00:00' => '20 jam' ,
      '21:00:00' => '21 jam' ,
      '22:00:00' => '22 jam' ,
      '23:00:00' => '23 jam' ,
      's' => '24 jam'
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
            <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
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
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true, 'value' => $mdl->ip_server]) ?>

        <?= $form->field($model, 'no_hp', [
          'template' => "
            <div class='row'>
              <div class='col-md-4' align='right'>{label}</div>
              <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
            </div>"])->textInput(['maxlength' => true, 'value' => $mdl->no_hp]) ?>

    <?= $form->field($model, 'gsm_to', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true, 'value' => $mdl->gsm_to]) ?>

    <?= $form->field($model, 'gps_to', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true, 'value' => $mdl->gps_to]) ?>



    <div class="form-group">
        <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
