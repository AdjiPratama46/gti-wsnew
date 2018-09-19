<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */

$this->title = 'Tambah Perangkat';
$this->params['breadcrumbs'][] = ['label' => 'Perangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-create" style="
                                  padding:20px;
                                  ">

    <center><h3><?= Html::encode($this->title) ?></h3></center><br>

    <?= $this->renderAjax('_form', [
        'model' => $model,
    ]) ?>

</div>
