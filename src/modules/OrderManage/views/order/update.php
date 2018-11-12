<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */

$this->title = t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Update');
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
