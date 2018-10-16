<?php
use yii\helpers\Html;
$this->title = 'MQTT config';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['mqtt/index']];
 ?>
 <div class="perangkat-index">
     <div class="box box-info">
         <div class="box-body">
           <?= Html::a('Publish', ['mqtt/publ'])?><br>
           <?= Html::a('Subscribe', ['mqtt/subs'])?>
          </div>
    </div>
</div>
