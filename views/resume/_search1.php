<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\Data;
use kartik\date\DatePicker;


if (Yii::$app->user->identity->role=="admin") {
    $query = 'SELECT * FROM perangkat,data WHERE perangkat.id=data.id_perangkat';
    $perangkats = ArrayHelper::map(Data::findBySql($query)->all(),'perangkat.id','perangkat.alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data GROUP BY tgl ORDER BY tgl DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}elseif (Yii::$app->user->identity->role=="user") {
    $id = Yii::$app->user->identity->id;
    $perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','alias');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.$id.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}
?>
<div class="resume-search">
    <div class="row">
        <div class="col-md-6 ">
          <?php $form = ActiveForm::begin([
              'action' => ['index'],
              'method' => 'get',
              'options' => [
                  'data-pjax' => 1
              ],
          ]); ?>
          <?= $form->field($model, 'id')->widget(Select2::classname(), [
              'data' => $perangkats,
              'options' => [
              'onchange'=>'this.form.submit()',
              ]

              ])->label(false) ?>


        </div>
        <div class="col-md-6">
          <?= $form->field($model, 'tahun')->widget(Select2::classname(), [
              'data' => $years,
              'options' => [
              'onchange'=>'this.form.submit()',
              ]

              ])->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
