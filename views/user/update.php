<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Account Setting';
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
