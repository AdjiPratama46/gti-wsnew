<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Data */

$this->title = 'Update Data: ' . $model->id_data;
$this->params['breadcrumbs'][] = ['label' => 'Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_data, 'url' => ['view', 'id' => $model->id_data]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
