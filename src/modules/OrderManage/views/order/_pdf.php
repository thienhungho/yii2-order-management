<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\Widgets\models\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Order').' '. Html::encode($this->title) ?></h2>
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
    
    <div class="row">
<?php
if($providerOrderItem->totalCount){
    $gridColumnOrderItem = [
        ['class' => 'yii\grid\SerialColumn'],         [             'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {                 return ['value' => $data->id];             },         ],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'product0.title',
                'label' => t('app', 'Product')
            ],
        'product_price',
        'quantity',
        'coupon',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrderItem,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(t('app', 'Order Item')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnOrderItem
    ]);
}
?>
    </div>
</div>
