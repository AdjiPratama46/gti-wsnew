<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perangkat */

$this->title = $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Perangkats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-view" style="padding:20px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

    <center><h3><?= Html::encode($this->title) ?></h3></center>
    <br>

    <p>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'alias',
            'id_owner',
            [
                'label' => 'Nama Pemilik',
                'attribute' => 'user.name',
            ],
            'tgl_instalasi',
            //'longitude',
            //'latitude',
            [
                'attribute'=>'Lokasi',
                'format'=>'raw',
                'value'=>$model->latitude.', '.$model->longitude,
            ],
        ],
    ]) ?>
    <br>
    <center><?php echo Html::a('Pindahkan/Ubah', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form btn btn-block btn-success butsub']); ?></center>
    <br>
</div>
