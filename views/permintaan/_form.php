<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Permintaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permintaan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_perangkat')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'id_user')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'tgl_pengajuan')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'tgl_tanggapan')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'pesan',[
        'template' => "<div class='row'><div class='col-md-4' align='right'>{label}</div><div class='col-md-8'><div style='width:60%'>{input}</div>{hint}{error}</div></div>",
        ])->textArea(['style' => 'resize: none;height:200px;']) ?>

    <div class="form-group">
        <center><?= Html::submitButton('Kirim', ['class' => 'btn btn-block btn-success butsub','data' => [
            'confirm' => 'Anda yakin akan menolak pengajuan ini?',
            'method' => 'post',
        ],]) ?></center>
    </div>

    <?php ActiveForm::end(); ?>

</div>
