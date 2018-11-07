<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Temptable */

$this->title = $model->id_perangkat;
?>
<div class="temptable-view" style="padding:20px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>
    <center><h3>Detail</h3></center>
    <br>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'id_perangkat',
            'latitude',
            'longitude',
            'altimeter',
            //'temperature',
            //'kelembapan',
            //'tekanan_udara',
            //'kecepatan_angin',
            //'arah_angin',
            //'curah_hujan',
            //'timestamp',
            //'status',
        ],
    ]) ?>
    <br>

</div>
