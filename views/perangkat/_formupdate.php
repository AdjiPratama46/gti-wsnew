<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="perangkat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
         ->textInput([
             'readonly' => true,
             'maxlength' => true,
             'style' => 'width: 100%;'])
    ?>

    <?= $form->field($model, 'alias', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
         ->textInput([
             'readonly' => true,
             'maxlength' => true,
             'style' => 'width: 100%;'])
    ?>

    <?= $form->field($model, 'id_owner')
        ->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false)
    ?>

    <?= $form->field($model, 'tgl_instalasi', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
        ->textInput([
           'readonly' => true,
           'maxlength' => true,
           'style' => 'width: 100%;'])
    ?>

    <?= $form->field($model, 'longitude', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
         ->textInput([
             'readonly' => true,
             'maxlength' => true,
             'style' => 'width: 100%;'])
    ?>

    <?= $form->field($model, 'latitude', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
         ->textInput([
             'readonly' => true,
             'maxlength' => true,
             'style' => 'width: 100%;'])
    ?>
    <?= $form->field($model, 'altitude', [
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        'options' => ['class' => 'form-group form-inline'],])
        ->textInput([
           'readonly' => true,
           'maxlength' => true,
           'style' => 'width: 100%;'])
      ?>

    <center><?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success butsub']) ?></center><br>

    <?php ActiveForm::end(); ?>

</div>
