<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permintaan */

$this->title = 'Tolak Pengajuan Perangkat' ;
?>
<div class="permintaan-update" style="padding:20px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>
    <center><h3><?= Html::encode($this->title) ?></h3>
    <h4>ID Perangkat : <?= $model->id_perangkat ?><h4></center>
      <br>

    <?= $this->renderAjax('_form', [
        'model' => $model,
    ]) ?>

</div>
