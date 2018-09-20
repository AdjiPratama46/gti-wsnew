<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */

$this->title = 'Pindahkan Perangkat : ' . $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Perangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="perangkat-update" style="
                                  padding:20px;
                                  ">

    <center><h3><?= Html::encode($this->title) ?></h3></center><br>

    <?= $this->renderAjax('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
