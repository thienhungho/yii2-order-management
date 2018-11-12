<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */

$this->title = t('app', 'Create Order');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
