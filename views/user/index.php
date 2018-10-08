<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <div class="box">
        <div class="box-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'username',
            'password',
            'role',
            //'accessToken',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
        </div>
    </div>
</div>