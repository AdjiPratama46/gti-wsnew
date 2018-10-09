<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-index box box-info">
<?php
        if (Yii::$app->user->identity->role=="admin") {
            $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class' => 'col-md-4 form-control']) ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?= $form->field($model, 'role')->dropDownList(['admin' => 'admin','user' => 'user']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-4">
                    <div class="form-group">
                        <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
                    </div>
                </div>

            </div>
            <?php ActiveForm::end(); 
        }elseif (Yii::$app->user->identity->role=="user") {
            $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class' => 'col-md-4 form-control']) ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-4">
                    <div class="form-group">
                        <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
                    </div>
                </div>

            </div>
            <?php ActiveForm::end(); 
        } ?>
</div>