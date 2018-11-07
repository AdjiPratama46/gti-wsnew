<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */

$this->title = $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Perangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-view" style="padding:20px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

    <center><h3>Detail</h3></center>
    <br>

    <p>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'alias',
            //'id_owner',
            [
                'label' => 'Nama Pemilik',
                'attribute' => 'user.name',
            ],
            [
              'attribute'=>'tgl_instalasi',
              'format' => ['date', 'php:d-m-Y'],
            ],
            //'longitude',
            //'latitude',
            [
                'attribute'=>'Lokasi',
                'format'=>'raw',
                'value'=>$model->latitude.', '.$model->longitude.', '.$model->altitude,
            ],
        ],
    ]) ?>
    <br>
    <center><?php
          if(Yii::$app->user->identity->role!='admin'){
            echo Html::a('Ubah', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form btn btn-block btn-success butsub']);
          }
             ?></center>
    <br>
</div>
