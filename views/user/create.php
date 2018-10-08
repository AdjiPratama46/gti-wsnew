<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create box">
    <div class="box-body">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <center><h3>Tambah Users</h3></center>
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <?= $form->field($model, 'username',['errorOptions' => ['tag' => null]])->textInput(['maxlength' => true,'class' => 'col-md-4 form-control']) ?>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                <?= $form->field($model, 'role',['errorOptions' => ['tag' => null]])->dropDownList(['admin' => 'admin','user' => 'user']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <?= $form->field($model, 'name',['errorOptions' => ['tag' => null]])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <?= $form->field($model, 'password',['errorOptions' => ['tag' => null]])->passwordInput(['maxlength' => true]) ?>
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
</div>