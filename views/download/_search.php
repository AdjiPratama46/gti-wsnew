<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Perangkat;
use app\models\Data;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DownloadSearch */
/* @var $form yii\widgets\ActiveForm */
if (Yii::$app->user->identity->role =='admin') {
    $perangkats = ArrayHelper::map(Perangkat::find()->all(),'id','id');
    $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');
}elseif (Yii::$app->user->identity->role =='user') {
    $perangkats = ArrayHelper::map(Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->all(),'id','id');
    $perangkatq= Perangkat::find()->where(['id_owner'=>Yii::$app->user->identity->id])->one();
    $sql = 'SELECT YEAR(tgl) as tgl FROM data,perangkat,user WHERE perangkat.id_owner = user.id AND perangkat.id = data.id_perangkat    AND user.id = "'.Yii::$app->user->identity->id.'" GROUP BY YEAR(tgl) ORDER BY YEAR(tgl) DESC';
    $years = ArrayHelper::map(Data::findBySql($sql)->all(),'tgl','tgl');


}

$months =array(
      '01' => 'Januari' ,
      '02' => 'Febuari' ,
      '03' => 'Maret' ,
      '04' => 'April' ,
      '05' => 'Mei' ,
      '06' => 'Juni' ,
      '07' => 'Juli' ,
      '08' => 'Agustus' ,
      '09' => 'September' ,
      '10' => 'Oktober' ,
      '11' => 'November' ,
      '12' => 'Desember' ,
    );

?>

<div class="data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
        <?= $form->field($model, 'id_perangkat',[
          'template' => '<div class="row"><div class="col-md-3" align="right">{label}</div><div class="col-md-7">{input}</div></div>'
          ])->widget(Select2::classname(), [
            'name' => 'id-perangkat',
            'id' => 'id-perangkat',
            'data' => $perangkats,
            'pluginOptions' => [
            'placeholder' => 'Pilih perangkat',

            ],
            'options' => [
            'onchange'=>'this.form.submit()',
            ]

            ])->label('ID Perangkat') ?>

            <?= $form->field($model, 'bulan',[
              'template' => '<div class="row"><div class="col-md-3" align="right">{label}</div><div class="col-md-7">{input}</div></div>'
              ])->widget(Select2::classname(), [
                'name' => 'bulan',
                'id' => 'bulan',
                'data' => $months,
                'pluginOptions' => [
                'placeholder' => 'Pilih bulan',
                'clearBtn' => true,

                ],
                'options' => [
                'onchange'=>'this.form.submit()',
                ]

                    ])->label('Bulan') ?>
        <?= $form->field($model, 'tahun',[
          'template' => '<div class="row"><div class="col-md-3" align="right">{label}</div><div class="col-md-7">{input}</div></div>'
          ])->widget(Select2::classname(), [
            'name' => 'tahun',
            'id' => 'tahun',
            'data' => $years,
            'pluginOptions' => [
            'placeholder' => 'Pilih tahun',
            'clearBtn' => true,

            ],
            'options' => [
            'onchange'=>'this.form.submit()',
            ]

            ])->label('Tahun') ?>


    <?php ActiveForm::end(); ?>

</div>
