<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permintaan */

$this->title = 'Update Permintaan: ' . $model->id;
?>
<div class="permintaan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->renderAjax('_form', [
        'model' => $model,
    ]) ?>

</div>
