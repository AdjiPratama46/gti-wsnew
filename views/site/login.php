<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->session->hasFlash('success')){
    ?>
<div id="note">
    <?= Yii::$app->session->getFlash('success'); ?>
</div>
<?php } ?>

<div class="login-box">
    <div class="login-logo">
        <?= Html::img('@web/images/logo-ws-3.png', ['alt'=>'User Image', 'class'=>'img-responsive img-logo']);?>
    </div>
    <div class="login-box-body box">
        <h2 class="text-center title"><?= Html::encode($this->title) ?></h2>
        <?php 
            $fieldUsername = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
            ];
            $fieldPassword = [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => "{input}<span class='nput-group-addon pwd'><span toggle='#loginform-password' class='form-control-feedback glyphicon glyphicon-eye-close field-icon toggle-password'></span></span>"
            ];

        ?>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); 
        ?>

        <?= $form->field($model, 'username',$fieldUsername)->textInput(['placeholder' => 'Masukkan Username'])->label(false) ?>

        <?= $form->field($model, 'password',$fieldPassword)->passwordInput(['placeholder' => 'Masukkan Password'])->label(false) ?>

        <!-- <?= $form->field($model, 'rememberMe')->checkbox([ 'template' => "<div
        class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div
        class=\"col-lg-8\">{error}</div>", ]) ?> -->

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-block btn-primary', 'id' => 'btn-gd' , 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div style="color:#999;">
            Anda belum punya akun? daftar
            <?= Html::a('disini', ['/site/signup'])?>
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