<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Account Setting';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
if(Yii::$app->session->hasFlash('success')){
    echo Yii::$app->session->getFlash('success');
}
?>
<div class="users-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
