<?php

use thienhungho\Widgets\models\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use thienhungho\OrderManagement\models\Order;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */
$this->title = t('app', 'Order') . '  #' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => t('app', 'Order'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <!--            --><? //=
            //            Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . t('app', 'PDF'),
            //                [
            //                    'pdf',
            //                    'id' => $model->id,
            //                ],
            //                [
            //                    'class'       => 'btn btn-danger',
            //                    'target'      => '_blank',
            //                    'data-toggle' => 'tooltip',
            //                    'title'       => t('app', 'Will open the generated PDF file in a new window'),
            //                ]
            //            ) ?>
            <!--            --><? //= Html::a(t('app', 'Save As New'), [
            //                'save-as-new',
            //                'id' => $model->id,
            //            ], ['class' => 'btn btn-info']) ?>
            <!--            --><? //= Html::a(t('app', 'Update'), [
            //                'update',
            //                'id' => $model->id,
            //            ], ['class' => 'btn btn-primary']) ?>
            <!--            --><? //= Html::a(t('app', 'Delete'), [
            //                'delete',
            //                'id' => $model->id,
            //            ], [
            //                'class' => 'btn btn-danger',
            //                'data'  => [
            //                    'confirm' => t('app', 'Are you sure you want to delete this item?'),
            //                    'method'  => 'post',
            //                ],
            //            ])
            //            ?>
        </div>
    </div>

    <div class="row">
        <?php
        $gridColumn = [
            [
                'attribute' => 'id',
                'visible'   => false,
            ],
            [
                'format'    => 'raw',
                'attribute' => 'status',
                'value'     => function($model, $key) {
                    if ($model->status == Order::STATUS_PENDING) {
                        return '<span class="label-warning label">' . t('app', slug_to_text(Order::STATUS_PENDING)) . '</span>';
                    } elseif ($model->status == Order::STATUS_SUCCESS) {
                        return '<span class="label-success label">' . t('app', slug_to_text(Order::STATUS_SUCCESS)) . '</span>';
                    } elseif ($model->status == Order::STATUS_PROCESSING) {
                        return '<span class="label-primary label">' . t('app', slug_to_text(Order::STATUS_PROCESSING)) . '</span>';
                    } elseif ($model->status == Order::STATUS_TRANSPORT) {
                        return '<span class="label-info label">' . t('app', slug_to_text(Order::STATUS_TRANSPORT)) . '</span>';
                    }
                },
            ],
            [
                'format'              => 'raw',
                'attribute'           => 'include_vat',
                'value'               => function($model, $key) {
                    if ($model->include_vat == YES) {
                        return '<span class="label-warning label">' . t('app', slug_to_text(YES)) . '</span>';
                    } elseif ($model->include_vat == NO) {
                        return '<span class="label-success label">' . t('app', slug_to_text(NO)) . '</span>';
                    }
                },
            ],
            [
                'format'              => 'raw',
                'attribute'           => 'payment_method',
                'value'               => function($model, $key) {
                    return '<span class="label-primary label">' . t('app', slug_to_text($model->payment_method)) . '</span>';
                },
            ],
            'note:ntext',
            'customer_username',
            'customer_phone',
            'customer_name',
            'customer_email:email',
            'customer_address',
            'customer_company',
            'customer_area',
            'customer_tax_number',
//            'ref_by',
            [
                'format'        => [
                    'date',
                    'php:Y-m-d h:s:i',
                ],
                'attribute'     => 'created_at'
            ],
            [
                'attribute'   => 'real_value',
                'format'      => [
                    'decimal',
                ],
            ],
            [
                'attribute'   => 'discount_value',
                'format'      => [
                    'decimal',
                ],
            ],
            [
                'attribute'   => 'total_price',
                'format'      => [
                    'decimal',
                ],
            ],
        ];
        echo DetailView::widget([
            'model'      => $model,
            'attributes' => $gridColumn,
        ]);
        ?>
    </div>

    <div class="row">
        <?php
        if ($providerOrderItem->totalCount) {
            $gridColumnOrderItem = [
                ['class' => 'kartik\grid\SerialColumn'],
//                [
//                    'class'           => 'yii\grid\CheckboxColumn',
//                    'checkboxOptions' => function($data) {
//                        return ['value' => $data->id];
//                    },
//                ],
                [
                    'attribute' => 'id',
                    'visible'   => false,
                ],
                [
                    'attribute' => 'product0.title',
                    'label'     => t('app', 'Product'),
                ],
                [
                    'attribute'   => 'product_price',
                    'format'      => [
                        'decimal',
                    ],
                ],
                [
                    'attribute'   => 'quantity',
                    'format'      => [
                        'decimal',
                    ],
                ],
                [
                    'attribute'   => 'product_unit',
                    'pageSummary' => t('app', 'Total'),
                ],
                [
                    'attribute'   => 'total_price',
                    'format'      => [
                        'decimal',
                    ],
                    'pageSummary' => true,
                ],
                'currency_unit',
            ];
            echo Gridview::widget([
                'dataProvider' => $providerOrderItem,
                'responsive'      => true,
                'responsiveWrap'  => false,
                'hover'           => true,
                'condensed'       => true,
                'pjax'         => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-order-item']],
                'panel'        => [
                    'type'    => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(t('app', 'Order Item')),
                ],
                'columns'      => $gridColumnOrderItem,
                'showPageSummary' => true,
            ]);
        }
        ?>

    </div>
</div>
