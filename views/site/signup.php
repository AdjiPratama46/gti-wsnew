<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <!-- <h2 class="text-center text-white text-shadow">WEATHER STATION</h2> -->
        <?= Html::img('@web/images/logo.png', ['alt'=>'User Image', 'class'=>'img-responsive img-logo']);?>
    </div>
    <div class="login-box-body box">
        <h2 class="text-center title"><?= Html::encode($this->title) ?></h2>
        <?php 
            $fieldUsername = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
            ];
            $fieldName = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
            ];
            $fieldPassword = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='nput-group-addon pwd'><span toggle='#signupform-password' class='form-control-feedback glyphicon glyphicon-eye-close field-icon toggle-password'></span></span>"
            ];

        ?>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); 
        ?>

        <?= $form->field($model, 'username',$fieldUsername)->textInput(['maxlength' => 30,'placeholder' => 'Masukkan Username'])->label(false) ?>

        <?= $form->field($model, 'name',$fieldName)->textInput(['maxlength' => 25,'placeholder' => 'Masukkan Nama'])->label(false) ?>

        <?= $form->field($model, 'password',$fieldPassword)->passwordInput(['maxlength' => 12,'placeholder' => 'Masukkan Password'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-block btn-primary', 'id' => 'btn-gd' , 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div style="color:#999;">
            Kembali ke halaman
            <?= Html::a('login', ['/site/login'])?>
        </div>
    </div>

</div>

<?php 
    $js = <<<js
    $(".toggle-password").click(function() {
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            $(this).removeClass("glyphicon glyphicon-eye-close");
            $(this).addClass("glyphicon glyphicon-eye-open");
            input.attr("type", "text");
        } else {
            $(this).removeClass("glyphicon glyphicon-eye-open");
            $(this).addClass("glyphicon glyphicon-eye-close");
            input.attr("type", "password");
        }
      });
js;
$this->registerJs($js);
?>