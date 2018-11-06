<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Temptable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temptable-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_perangkat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'altimeter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'temperature')->textInput() ?>

    <?= $form->field($model, 'kelembapan')->textInput() ?>

    <?= $form->field($model, 'tekanan_udara')->textInput() ?>

    <?= $form->field($model, 'kecepatan_angin')->textInput() ?>

    <?= $form->field($model, 'arah_angin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'curah_hujan')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
