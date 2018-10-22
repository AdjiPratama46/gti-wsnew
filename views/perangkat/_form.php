<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="perangkat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idp', [
      'template' => "{input}"])->widget(Select2::classname(), [
        'data' => $perangkt,

        'pluginOptions' => [
            'placeholder' =>'Pilih ID Perangkat',
            'clearBtn' => true,
        ]])->label(false) ?>


    <div class="form-group">
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success butsub']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
