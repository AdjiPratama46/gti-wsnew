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
      '24:00:00' => '24 jam'
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

            <div class="row">
              <div class='col-md-4' align='right'><label>GSM Time Out</label></div>
              <div class='col-md-5'>
                  <div style="width:49.3%;display:inline-block">
                    <?= $form->field($model, 'gsm_to_h', [
                      'template' => "{input}"])->widget(Select2::classname(), [
                        'data' => $jam1,

                        'pluginOptions' => [
                            'placeholder' =>'Pilih jam',
                            'clearBtn' => true,
                        ],
                        'options' => [
                          'value'=> $gsmto_h,
                        ]])->label(false) ?>
                  </div>
                  <div style="width:49.3%;display:inline-block">
                    <?= $form->field($model, 'gsm_to_m', [
                      'template' => "{input}"])->widget(Select2::classname(), [
                        'data' => $menit,

                        'pluginOptions' => [
                            'placeholder' =>'Pilih jam',
                            'clearBtn' => true,
                        ],
                        'options' => [
                          'value'=> $gsmto_m,
                        ]])->label(false) ?>
                  </div>
              </div>
              <div class="col-md-3"><?= Html::error($model, 'gsm_to_m',['style'=> 'color:#dd4b39']); ?>
              </div>
            </div>

            <div class="row">
              <div class='col-md-4' align='right'><label>GSM Time Out</label></div>
              <div class='col-md-5'>
                  <div style="width:49.3%;display:inline-block">
                    <?= $form->field($model, 'gps_to_h', [
                      'template' => "{input}"])->widget(Select2::classname(), [
                        'data' => $jam1,

                        'pluginOptions' => [
                            'placeholder' =>'Pilih jam',
                            'clearBtn' => true,
                        ],
                        'options' => [
                          'value'=> $gpsto_h,
                        ]])->label(false) ?>
                  </div>
                  <div style="width:49.3%;display:inline-block">
                    <?= $form->field($model, 'gps_to_m', [
                      'template' => "{input}"])->widget(Select2::classname(), [
                        'data' => $menit,

                        'pluginOptions' => [
                            'placeholder' =>'Pilih jam',
                            'clearBtn' => true,
                        ],
                        'options' => [
                          'value'=> $gpsto_m,
                        ]])->label(false) ?>
                  </div>
              </div>
              <div class="col-md-3"><?= Html::error($model, 'gps_to_m',['style'=> 'color:#dd4b39']); ?>
              </div>
            </div>





    <div class="form-group">
        <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
