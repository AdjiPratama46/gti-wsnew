<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Data */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-form">
    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'id_perangkat')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tgl')->textInput() ?>

            <?= $form->field($model, 'kelembaban')->textInput() ?>

            <?= $form->field($model, 'kecepatan_angin')->textInput() ?>

            <?= $form->field($model, 'arah_angin')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'curah_hujan')->textInput() ?>

            <?= $form->field($model, 'temperature')->textInput() ?>


            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>