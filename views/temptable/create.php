<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Temptable */

$this->title = 'Create Temptable';
$this->params['breadcrumbs'][] = ['label' => 'Temptables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temptable-create" >


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
