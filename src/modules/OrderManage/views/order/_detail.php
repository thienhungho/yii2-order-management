<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */

?>
<div class="order-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->id) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'status',
        'payment_method',
        'note:ntext',
        'include_vat',
        'customer_username',
        'customer_phone',
        'customer_name',
        'customer_email:email',
        'customer_address',
        'customer_company',
        'customer_area',
        'customer_tax_number',
        'ref_by',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>