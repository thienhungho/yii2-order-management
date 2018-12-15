<?php
/* @var $this yii\web\View */
/* @var $searchModel thienhungho\OrderManagement\modules\MyOrder\search\OrderSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use thienhungho\Widgets\models\GridView;
use thienhungho\OrderManagement\models\Order;
use yii\helpers\Html;

$this->title = t('app', 'My Orders');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>

    <div class="order-index-head">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-10">
                <p>
                    <?= Html::a(t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a(t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
                </p>
            </div>
            <div class="col-lg-2">
                <?php backend_per_page_form() ?>
            </div>
        </div>
        <div class="search-form" style="display:none">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]); ?>
        </div>
    </div>

<?= Html::beginForm(['bulk']) ?>
    <div class="order-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php
        $gridColumn = [
            ['class' => '\kartik\grid\SerialColumn'],
            grid_checkbox_column(),
            [
                'attribute' => 'id',
                'visible'   => false,
            ],
//            [
//                'class'         => 'kartik\grid\ExpandRowColumn',
//                'width'         => '50px',
//                'value'         => function($model, $key, $index, $column) {
//                    return GridView::ROW_COLLAPSED;
//                },
//                'detail'        => function($model, $key, $index, $column) {
//                    return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
//                },
//                'headerOptions' => ['class' => 'kartik-sheet-style'],
//                'expandOneOnly' => true,
//            ],
            //        'customer_address',
            //        'customer_company',
            //        'customer_area',
            //        'customer_tax_number',
            //        'note:ntext',
            [
                'format'              => 'raw',
                'attribute'           => 'payment_method',
                'value'               => function($model, $key, $index, $column) {
                    return '<span class="label-primary label">' . t('app', slug_to_text($model->payment_method)) . '</span>';
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => [
                    Order::PAYMENT_MEDTHOD_COD            => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_COD)),
                    Order::PAYMENT_MEDTHOD_VISA           => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_VISA)),
                    Order::PAYMENT_MEDTHOD_MASTER_CARD    => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_MASTER_CARD)),
                    Order::PAYMENT_MEDTHOD_PAYPAL         => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_PAYPAL)),
                    Order::PAYMENT_MEDTHOD_ONLINE_BANKING => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_ONLINE_BANKING)),
                    Order::PAYMENT_MEDTHOD_CASH           => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_CASH)),
                ],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'Payment Method'),
                    'id'          => 'grid-search-payment-method',
                ],
                'pageSummary' => Yii::t('app', 'Total'),
            ],
            [
                'format'              => 'raw',
                'attribute'           => 'include_vat',
                'value'               => function($model, $key, $index, $column) {
                    if ($model->include_vat == YES) {
                        return '<span class="label-warning label">' . t('app', slug_to_text(YES)) . '</span>';
                    } elseif ($model->include_vat == NO) {
                        return '<span class="label-success label">' . t('app', slug_to_text(NO)) . '</span>';
                    }
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => \yii\helpers\ArrayHelper::map([
                    [
                        'value' => YES,
                        'name'  => t('app', slug_to_text(YES)),
                    ],
                    [
                        'value' => NO,
                        'name'  => t('app', slug_to_text(NO)),
                    ],
                ], 'value', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'Status'),
                    'id'          => 'grid-search-include-vat',
                ],
            ],
            [
                'attribute'   => 'real_value',
                'format'      => [
                    'decimal',
                ],
                'pageSummary' => true,
            ],
            [
                'attribute'   => 'discount_value',
                'format'      => [
                    'decimal',
                ],
                'pageSummary' => true,
            ],
            [
                'attribute'   => 'total_price',
                'format'      => [
                    'decimal',
                ],
                'pageSummary' => true,
            ],
            [
                'format'              => 'raw',
                'attribute'           => 'status',
                'value'               => function($model, $key, $index, $column) {
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
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => \yii\helpers\ArrayHelper::map([
                    [
                        'value' => Order::STATUS_PENDING,
                        'name'  => t('app', slug_to_text(Order::STATUS_PENDING)),
                    ],
                    [
                        'value' => Order::STATUS_PROCESSING,
                        'name'  => t('app', slug_to_text(Order::STATUS_PROCESSING)),
                    ],
                    [
                        'value' => Order::STATUS_TRANSPORT,
                        'name'  => t('app', slug_to_text(Order::STATUS_TRANSPORT)),
                    ],
                    [
                        'value' => Order::STATUS_SUCCESS,
                        'name'  => t('app', slug_to_text(Order::STATUS_SUCCESS)),
                    ],
                ], 'value', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'Status'),
                    'id'          => 'grid-search-status',
                ],
            ],
            [
                'format'        => [
                    'date',
                    'php:Y-m-d h:s:i',
                ],
                'attribute'     => 'created_at',
                'filterType'    => GridView::FILTER_DATETIME,
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
        ];
        $action_column = grid_view_default_active_column_cofig();
        $action_column['template'] = '{view} {save-as-new}';
        $gridColumn[] = $action_column;
        ?>
        <?= GridView::widget([
            'dataProvider'    => $dataProvider,
            'filterModel'     => $searchModel,
            'columns'         => $gridColumn,
            'responsive'      => true,
            'responsiveWrap'  => false,
            'hover'           => true,
            'condensed'       => true,
            'pjax'            => true,
            'pjaxSettings'    => ['options' => ['id' => 'kv-pjax-container-order']],
            'panel'           => [
                'type'    => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
            // your toolbar can include the additional full export menu
            'toolbar'         => grid_view_toolbar_config($dataProvider, $gridColumn),
            'showPageSummary' => true,
        ]); ?>

        <div class="row">
            <div class="col-lg-2">
                <?= \kartik\widgets\Select2::widget([
                    'name'    => 'action',
                    'data'    => [
                        ACTION_DELETE            => t('app', 'Delete'),
                        Order::STATUS_PENDING    => t('app', slug_to_text(Order::STATUS_PENDING)),
                        Order::STATUS_PROCESSING => t('app', slug_to_text(Order::STATUS_PROCESSING)),
                        Order::STATUS_TRANSPORT  => t('app', slug_to_text(Order::STATUS_TRANSPORT)),
                        Order::STATUS_SUCCESS    => t('app', slug_to_text(Order::STATUS_SUCCESS)),
                    ],
                    'theme'   => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'multiple'    => false,
                        'placeholder' => t('app', 'Bulk Actions ...'),
                    ],
                ]); ?>
            </div>
            <div class="col-lg-10">
                <?= Html::submitButton(t('app', 'Apply'), [
                    'class'        => 'btn btn-primary',
                    'data-confirm' => t('app', 'Are you want to do this?'),
                ]) ?>
            </div>
        </div>

    </div>

<?= Html::endForm() ?>