<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-index text-center">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('New Password') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <?= $form->field($model, 'password')->passwordInput(['disabled' => true])->label('Old Password') ?>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-4">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
