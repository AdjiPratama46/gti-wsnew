<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="site-login">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="thumbnail">
                    <div class="caption">
                        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

                        <?php $form = ActiveForm::begin([
                        'id' => 'signup-form',
                        ]); ?>

                        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Masukkan Username'])->label(false) ?>

                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Masukkan Nama'])->label(false) ?>

                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Masukkan Password'])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-block btn-primary', 'name' => 'register-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>