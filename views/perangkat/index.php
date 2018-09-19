<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerangkatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perangkat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perangkat-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php echo Html::a('Tambah Perangkat', ['perangkat/create'], ['class' => 'modal-form btn btn-success']); ?>
    <p>
        <?php /* Html::a('Create Perangkat', ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alias',
            'id_owner',
            'tgl_instalasi',
            'longitude',
            'latitude',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
