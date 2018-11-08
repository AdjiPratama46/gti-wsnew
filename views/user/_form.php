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
                    <?= $form->field($model, 'username')->textInput([
                      'readonly' => true,'maxlength' => 25,'class' => 'col-md-4 form-control']) ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?= $form->field($model, 'role')->dropDownList(['admin' => 'admin','user' => 'user']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?php
                    if(Yii::$app->user->identity->id == $model->id){
                        echo $form->field($model, 'name')->textInput(['maxlength' => 25]);
                    }else{
                        echo $form->field($model, 'name')->textInput(['readonly' => true,'maxlength' => 25]);
                    }
                    ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <?php
                  if(Yii::$app->user->identity->id == $model->id){
                    echo $form->field($model, 'new_password')->passwordInput(['maxlength' => 12]);
                  }else{
                    //MERESET PASSWORD MENJADI 'QWERTY'
                    echo '<label style="opacity:0;">.</label><br>';
                    echo Html::a('Reset Password', ['resetpw', 'id' => $model->id], ['class' => 'btn btn-danger','style'=>'width:100%;','data' => [
                        'confirm' => 'Anda yakin akan mereset password user ini?',
                        'method' => 'post',
                    ],]);
                  }
                    ?>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-4">
                    <div class="form-group">
                        <?= $form->field($model, 'confirm_password')->hiddenInput(['value' => $model->password])->label(false) ?>
                        <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success']) ?>

                    </div>
                </div>

            </div>
            <?php ActiveForm::end();
        }elseif (Yii::$app->user->identity->role=="user") {
            $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => 30,'class' => 'col-md-4 form-control']) ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => 12]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 12]) ?>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-4">
                    <div class="form-group">
                        <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success']) ?>
                    </div>
                </div>

            </div>
            <?php ActiveForm::end();
        } ?>
</div>
