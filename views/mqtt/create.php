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
        ]) ?>
       </div>
       <?= Html::a('Subscribe', ['mqtt/subs'])?>
 </div>


</div>
