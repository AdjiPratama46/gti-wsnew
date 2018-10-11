<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">
    <div class="box-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <center>
            <h3><?= Html::encode($this->title) ?></h3>
        </center>
        <br>

        <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'name',
            'username',
            [
                'attribute' => 'password',
                'value' => '************'
            ],
            'authKey',
            'accessToken',
            'role',
            // [
            //     'attribute' => 'perangkat.alias',
            //     'label' => 'Perangkat',
            // ],
        ],
    ]) ?>
        <br>
        <center><?php echo Html::a('Ubah', ['user/update', 'id' => $model->id], ['class' => 'btn btn-block btn-success butsub']); ?></center>
        <br>
    </div>
</div>