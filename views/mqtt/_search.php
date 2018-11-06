<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KonfigurasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="konfigurasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'interval') ?>

    <?= $form->field($model, 'ip_server') ?>

    <?= $form->field($model, 'no_hp') ?>

    <?php // echo $form->field($model, 'gsm_to') ?>

    <?php // echo $form->field($model, 'gps_to') ?>

    <?php // echo $form->field($model, 'ussd_code') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
