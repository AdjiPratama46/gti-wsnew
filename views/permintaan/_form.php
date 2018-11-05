<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Permintaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permintaan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_perangkat')->textInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'id_user')->textInput()->label(false) ?>
    <?= $form->field($model, 'status')->textInput()->label(false) ?>
    <?= $form->field($model, 'tgl_pengajuan')->textInput()->label(false) ?>
    <?= $form->field($model, 'tgl_tanggapan')->textInput()->label(false) ?>
    <?= $form->field($model, 'pesan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
