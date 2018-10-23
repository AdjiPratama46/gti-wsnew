<?php

use yii\helpers\Html;

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
            ])
        ?>
       </div>
 </div>


</div>
