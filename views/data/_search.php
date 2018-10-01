<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\Data;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\DataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php //$form->field($model, 'id_data') ?>
    <div class="row">
    <div class="col-md-6"></div>
      <div class="col-md-3">
            <?php $perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias');

            echo $form->field($model, 'id_perangkat')->widget(Select2::classname(), [
                                  'data' => $perangkats,
                                  'pluginOptions' => [
                                    'placeholder' => 'Pilih perangkat',
                                    'clearBtn' => true,

                                  ],
                                  'options' => [
                                    'onchange'=>'this.form.submit()',
                                  ]

                          ])->label(false); ?>
          </div><div class="col-md-3">
            <?= $form->field($model, 'tgl')->widget(DatePicker::ClassName(),[
                'name' => 'tgl',
                'id' => 'tgl',
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose'=>false,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => [
                  'placeholder' => 'Pilih tanggal',
                  'onchange'=>'this.form.submit()',
                ]
            ])->label(false); ?>

          </div>

    <?php //$form->field($model, 'kelembaban') ?>

    <?php //$form->field($model, 'kecepatan_angin') ?>

    <?php // echo $form->field($model, 'arah_angin') ?>

    <?php // echo $form->field($model, 'curah_hujan') ?>

    <?php // echo $form->field($model, 'temperature') ?>

    <?php // echo $form->field($model, 'kapasitas_baterai') ?>

    <!-- <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

</div>
