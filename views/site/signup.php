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
        <h2 class="text-center text-white text-shadow">GTI - WEATHER STATION</h2>
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
                'inputTemplate' => "{input}<span class='nput-group-addon pwd'><span toggle='#signupform-password' class='form-control-feedback glyphicon glyphicon-eye-open field-icon toggle-password'></span></span>"
            ];

        ?>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); 
        ?>

        <?= $form->field($model, 'username',$fieldUsername)->textInput(['autofocus' => true,'placeholder' => 'Masukkan Username'])->label(false) ?>

        <?= $form->field($model, 'name',$fieldName)->textInput(['placeholder' => 'Masukkan Nama'])->label(false) ?>

        <?= $form->field($model, 'password',$fieldPassword)->passwordInput(['placeholder' => 'Masukkan Password'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-block btn-primary', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<?php 
    $js = <<<js
    $(".toggle-password").click(function() {
        $(this).toggleClass(".glyphicon glyphicon-eye-close");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
js;
$this->registerJs($js);
?>