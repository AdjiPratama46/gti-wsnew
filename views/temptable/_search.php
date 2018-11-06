<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TemptableSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="temptable-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_perangkat') ?>

    <?= $form->field($model, 'latitude') ?>

    <?= $form->field($model, 'longitude') ?>

    <?= $form->field($model, 'altimeter') ?>

    <?php // echo $form->field($model, 'temperature') ?>

    <?php // echo $form->field($model, 'kelembapan') ?>

    <?php // echo $form->field($model, 'tekanan_udara') ?>

    <?php // echo $form->field($model, 'kecepatan_angin') ?>

    <?php // echo $form->field($model, 'arah_angin') ?>

    <?php // echo $form->field($model, 'curah_hujan') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
