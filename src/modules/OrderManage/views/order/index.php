<?php
/* @var $this yii\web\View */
/* @var $searchModel thienhungho\OrderManagement\modules\OrderManage\search\OrderSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use thienhungho\OrderManagement\models\Order;
use thienhungho\UserManagement\models\User;

$this->title = t('app', 'Order');
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
            'model'     => $searchModel,
        ]); ?>
    </div>
</div>

<?= Html::beginForm(['bulk']) ?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $gridColumn = [
        grid_serial_column(),
        grid_checkbox_column(),
        [
            'attribute' => 'id',
            'visible'   => false,
        ],
        [
            'class'         => 'kartik\grid\ExpandRowColumn',
            'width'         => '50px',
            'value'         => function($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'        => function($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
        ],
        [
            'attribute'           => 'customer_username',
            'label'               => t('app', 'Customer Username'),
            'value'               => function($model) {
                return $model->customer_username;
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(User::find()
                ->asArray()
                ->all(), 'username', 'username'
            ),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Customer Username'),
                'id'          => 'grid-order-search-customer-username',
            ],
        ],
        'customer_phone',
        'customer_name',
        'customer_email:email',
//        'customer_address',
//        'customer_company',
//        'customer_area',
//        'customer_tax_number',
//        'note:ntext',
        [
            'attribute'           => 'ref_by',
            'label'               => t('app', 'Ref By'),
            'value'               => function($model) {
                if ($model->ref_by) {
                    return $model->ref_by->username;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(User::find()
                ->asArray()
                ->all(), 'id', 'username'
            ),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Ref By'),
                'id'          => 'grid-order-search-ref-by',
            ],
        ],
        'payment_method',
        'include_vat',
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
                ]
            ], 'value', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Status'),
                'id'          => 'grid-search-status',
            ],
        ],
    ];
    $gridColumn[] = grid_view_default_active_column_cofig();
    ?>
    <?= GridView::widget([
        'dataProvider'   => $dataProvider,
        'filterModel'    => $searchModel,
        'columns'        => $gridColumn,
        'responsiveWrap' => false,
        'condensed'      => true,
        'hover'          => true,
        'pjax'           => true,
        'pjaxSettings'   => ['options' => ['id' => 'kv-pjax-container-order']],
        'panel'          => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar'        => grid_view_toolbar_config($dataProvider, $gridColumn),
    ]); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= \kartik\widgets\Select2::widget([
                'name'    => 'action',
                'data'    => [
                    ACTION_DELETE  => t('app', 'Delete'),
                    Order::STATUS_PENDING   => t('app', slug_to_text(Order::STATUS_PENDING)),
                    Order::STATUS_PROCESSING => t('app', slug_to_text(Order::STATUS_PROCESSING)),
                    Order::STATUS_TRANSPORT  => t('app', slug_to_text(Order::STATUS_TRANSPORT)),
                    Order::STATUS_SUCCESS  => t('app', slug_to_text(Order::STATUS_SUCCESS)),
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