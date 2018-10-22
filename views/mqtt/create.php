<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Konfigurasi */

$this->title = 'MQTT konfigurasi';
$this->params['breadcrumbs'][] = ['label' => 'Konfigurasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konfigurasi-create">

  <div class="box box-info">
      <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
            'mdl' => $mdl,
            'gsmto_h' => $gsmto_h,
            'gsmto_m' => $gsmto_m,
            'gpsto_h' => $gpsto_h,
            'gpsto_m' => $gpsto_m,
        ]) ?>
       </div>
 </div>


</div>
