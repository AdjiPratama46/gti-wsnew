<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
//use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Konfigurasi */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="konfigurasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?php
          //$form->field($model, 'frekuensi')->widget(TimePicker::className(), [


//])
    ?>
    <?= $form->field($model, 'frekuensi', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip_server', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'no_hp', [
          'template' => "
            <div class='row'>
              <div class='col-md-4' align='right'>{label}</div>
              <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
            </div>"])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gsm_to', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gps_to', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>"])->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
