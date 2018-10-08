<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Data */

$this->title = $model->id_data;
$this->params['breadcrumbs'][] = ['label' => 'Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-view">
    <div class="box">
        <div class="box-body">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id_data], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id_data], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
            </p>

            <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover table-striped table-bordered detail-view'],
        'attributes' => [
            'id_data',
            'id_perangkat',
            'tgl',
            'kelembaban',
            'kecepatan_angin',
            'arah_angin',
            'curah_hujan',
            'temperature',
            'kapasitas_baterai',
        ],
    ]) ?>

        </div>
    </div>
</div>