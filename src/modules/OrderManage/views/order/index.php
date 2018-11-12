<?php

/* @var $this yii\web\View */
/* @var $searchModel thienhungho\OrderManagement\modules\OrderManage\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = t('app', 'Order');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],         [             'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {                 return ['value' => $data->id];             },         ],
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
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{save-as-new} {view} {update} {delete}',
            'buttons' => [
                'save-as-new' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, ['title' => t('app', 'Save As New')]);
                },
            ],
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'responsiveWrap' => false,
        'hover'          => true,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-order']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => t('app', 'Full'),
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">' . t('app', 'Export All Data') . '</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
