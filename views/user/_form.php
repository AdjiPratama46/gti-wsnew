<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-index box box-info">
<?php
        if (Yii::$app->user->identity->role=="admin") {
            $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-5 text-center"> <!-- Profile Picture Start-->
                    <!-- <img src="..." alt="Foto Profil" class="img-rounded"> -->
                    <hr>
                    <?= Html::img('@web/images/'.$model->gambar, ['alt'=>'User Image','id'=>'ip', 'class'=>'img-circle img-responsive img-profile']);?>
                    <hr>
                    <!-- <input id="ifp" type="file" name="ifp" accept="image/*"> -->
                    <?= $form->field($model, 'filegambar')->fileInput(['accept' => 'image/*','id' => 'ifp'])->label(false); ?>
                </div> <!-- Profile Picture End-->
                <div class="col-sm-12 col-md-7 col-lg-7"> <!-- Form  Start-->
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'username')->textInput(['readonly' => true,'maxlength' => 25]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'role')->dropDownList(['admin' => 'admin','user' => 'user']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?php
                                    if(Yii::$app->user->identity->id == $model->id){
                                        echo $form->field($model, 'name')->textInput(['maxlength' => 25]);
                                    }else{
                                        echo $form->field($model, 'name')->textInput(['readonly' => true,'maxlength' => 25]);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
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
                    </div> <!-- Form End -->
                    <div class="row">

                        <div class="col-sm-12 col-md-4 col-lg-4 col-md-offset-3">
                            <div class="form-group">
                                <?= $form->field($model, 'confirm_password')->hiddenInput(['value' => $model->password])->label(false) ?>
                                <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success']) ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php ActiveForm::end();
        }elseif (Yii::$app->user->identity->role=="user") {
            $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-5 text-center"> <!-- Profile Picture Start-->
                        <!-- <img src="..." alt="Foto Profil" class="img-rounded"> -->
                        <hr>
                        <?= Html::img('@web/images/'.$model->gambar, ['alt'=>'User Image','id'=>'ip', 'class'=>'img-circle img-responsive img-profile']);?>
                        <hr>
                        <!-- <input id="ifp" type="file" name="ifp" accept="image/*"> -->
                        <?= $form->field($model, 'filegambar')->fileInput(['accept' => 'image/*','id' => 'ifp'])->label(false); ?>
                    </div> <!-- Profile Picture End-->

                    <div class="col-sm-12 col-md-7 col-lg-7"> <!-- Form  Start-->
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'username')->textInput(['maxlength' => 30]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => 12]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => 12]) ?>
                            </div>
                        </div>
                    </div> <!-- Form End -->

                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4 col-md-offset-3">
                            <div class="form-group">
                            <hr>
                                <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-block btn-success']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end();
        } ?>
</div>
<?php
    $this->registerJs("
        $('#fp').click(function (e){
            $('#ifp').click()
        });
        $('#ip').click(function (e){
            $('#ifp').click()
        });
        $('#ifp').change(function (e){
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('ip');
                output.src = reader.result;

            }
            filename = $('#ifp').val();
            if (filename.substring(3,11) == 'fakepath') {
                filename = filename.substring(12);
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    ");
?>
