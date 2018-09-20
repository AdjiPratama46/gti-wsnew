<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'alias',
            'id_owner',
            'tgl_instalasi',
            'longitude',
            'latitude',
        ],
    ]) ?>

</div>
