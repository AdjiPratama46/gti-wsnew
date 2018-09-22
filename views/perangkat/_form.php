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
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
        </div>",
       'options' => ['class' => 'form-group form-inline'],])
       ->textInput([
         'maxlength' => true,
        'style' => 'width: 100%;']) ?>

    <?= $form->field($model, 'alias', [
        'template' => "
          <div class='row'>
            <div class='col-md-4' align='right'>{label}</div>
            <div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div>
          </div>",
       'options' => ['class' => 'form-group form-inline'],])
       ->textInput([
         'maxlength' => true,
        'style' => 'width: 100%;']) ?>

    <?= $form->field($model, 'id_owner', [
        'template' => "{label}{input}{hint}{error}",
         'options' => ['class' => 'form-group form-inline'],])
         ->hiddenInput([
           'value' => Yii::$app->user->identity->id,
           'maxlength' => true,
          'style' => 'width: 100%;'])->label(false) ?>

    <?= $form->field($model, 'tgl_instalasi',[
          'template' => "
            <div class='row'>
              <div class='col-md-4' align='right'>{label}</div>
              <div class='col-md-8' ><div style='width:60%'>{input}</div>{hint}{error}</div>
            </div>",
           'options' => ['class' => 'form-group form-inline'],]
           )->widget(DatePicker::ClassName(),[
            'name' => 'tgl_instalasi',

            'readonly' => 'readonly',
            'options' => [
                'placeholder' => '',
                //'value' => date('Y-m-d'),
                'style' => 'width: 100%;',
            ],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
                'startDate' =>  date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)),
                'endDate' =>  date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)),
                //'endDate' => date('Y-m-d'),
            ],

          ]);?>

    <?= $form->field($model, 'longitude', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'>{input}{hint}{error}</div>
        </div>",
       'options' => ['class' => 'form-group form-inline'],])
       ->textInput([
         'maxlength' => true,
        'style' => 'width: 60%;']) ?>

    <?= $form->field($model, 'latitude', [
      'template' => "
        <div class='row'>
          <div class='col-md-4' align='right'>{label}</div>
          <div class='col-md-8'>{input}{hint}{error}</div>
        </div>",
       'options' => ['class' => 'form-group form-inline'],])
       ->textInput([
         'maxlength' => true,
        'style' => 'width: 60%;']) ?>

    <div class="form-group">
        <div class="row">
            <div class="col-md-8 col-md-offset-4">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success butsub']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>