<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

    <?= $form->field($model, 'id_data') ?>

    <?= $form->field($model, 'id_perangkat') ?>

    <?= $form->field($model, 'tgl') ?>

    <?= $form->field($model, 'kelembaban') ?>

    <?= $form->field($model, 'kecepatan_angin') ?>

    <?php // echo $form->field($model, 'arah_angin') ?>

    <?php // echo $form->field($model, 'curah_hujan') ?>

    <?php // echo $form->field($model, 'temperature') ?>

    <?php // echo $form->field($model, 'kapasitas_baterai') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
