<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Perangkat;
use dosamigos\datepicker\DatePicker;
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
            //'id_owner',
            [
                'attribute'=>'tgl_instalasi',
                'value'=>'tgl_instalasi',
                'format'=>'raw',
                'filter'=>DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'tgl_instalasi',
                    'options' => [
                      'readonly' => 'readonly',
                    ],
                    'template' => '{addon}{input}',
                          'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d',
                            'clearBtn' => true,
                          ],
                          'clientEvents' => [
                              'clearDate' => 'function (e) {$(e.target).find("input").change();}',
                          ],
                ])
            ],
            'longitude',
            'latitude',
            [
            'header' => 'Aksi',
            'content' => function($model) {
                return Html::a('Pindah', ['perangkat/update', 'id' => $model->id], ['class' => 'modal-form btn btn-success', 'data-pjax' => 0]);
            }
],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <br>
    <div class="maps-bg">
      <h3><icon class="glyphicon glyphicon-map-marker"></icon> Peta Lokasi </h3>
      <?= $map->display() ?>
    </div>
</div>
