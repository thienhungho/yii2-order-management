<div class="form-group" id="add-order-item">
    <?php

    use kartik\builder\TabularForm;
    use kartik\grid\GridView;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;

    $dataProvider = new ArrayDataProvider([
        'allModels'  => $row,
        'pagination' => [
            'pageSize' => -1,
        ],
    ]);
    echo TabularForm::widget([
        'dataProvider'      => $dataProvider,
        'formName'          => 'OrderItem',
        'checkboxColumn'    => false,
        'actionColumn'      => false,
        'attributeDefaults' => [
            'type' => TabularForm::INPUT_TEXT,
        ],
        'attributes'        => [
            "id"             => [
                'type'          => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true],
            ],
            'product'        => [
                'label'         => Yii::t('app', 'Product'),
                'type'          => TabularForm::INPUT_WIDGET,
                'widgetClass'   => \kartik\widgets\Select2::className(),
                'options'       => [
                    'data'    => \yii\helpers\ArrayHelper::map(
                        \thienhungho\ProductManagement\models\Product::find()
                            ->orderBy('title')
                            ->asArray()
                            ->all(), 'id', 'title'),
                    'options' => ['placeholder' => t('app', 'Choose Product')],
                ],
                'columnOptions' => ['width' => '200px'],
            ],
            'quantity'       => [
                'label'       => Yii::t('app', 'Quantity'),
                'type'        => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => ' ',
                        'suffix' => ' ',
                        'digits' => 2,
                    ],
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
            ],
            'product_unit'   => [
                'type'  => TabularForm::INPUT_HIDDEN_STATIC,
                'label' => Yii::t('app', 'Product Unit'),
            ],
            'product_price'  => [
                'label' => Yii::t('app', 'Product Price'),
                'type'  => 'raw',
                'value' => function($model, $key) {
                    if (!empty($model['product_price']) && !empty($model['currency_unit'])) {
                        return '<span style="font-weight: bold; color: darkblue">' . format_product_price($model['product_price']) . '</span>' . ' (' . $model['currency_unit'] . ')';
                    }
                    return null;
                },
            ],
            'real_value'     => [
                'label' => Yii::t('app', 'Real Value'),
                'type'  => TabularForm::INPUT_RAW,
                'value' => function($model, $key) {
                    if (!empty($model['real_value']) && !empty($model['currency_unit'])) {
                        return '<span style="font-weight: bold; color: red">' . format_product_price($model['real_value']) . '</span>' . ' (' . $model['currency_unit'] . ')';
                    }
                    return null;
                },
            ],
            'discount_value' => [
                'label' => Yii::t('app', 'Discount Value'),
                'type'  => TabularForm::INPUT_RAW,
                'value' => function($model, $key) {
                    if (!empty($model['discount_value']) && !empty($model['currency_unit'])) {
                        return '<span style="font-weight: bold; color: darkgreen">' . format_product_price($model['discount_value']) . '</span>' . ' (' . $model['currency_unit'] . ')';
                    }

                    return null;
                },
            ],
            'total_price'    => [
                'label' => Yii::t('app', 'Total Price'),
                'type'  => TabularForm::INPUT_RAW,
                'value' => function($model, $key) {
                    if (!empty($model['total_price']) && !empty($model['currency_unit'])) {
                        return '<span style="font-weight: bold; color: green">' . format_product_price($model['total_price']) . '</span>' . ' (' . $model['currency_unit'] . ')';
                    }

                    return null;
                },
            ],
            'coupon'         => [
                'type'  => TabularForm::INPUT_TEXT,
                'label' => Yii::t('app', 'Coupon'),
            ],
            'del'            => [
                'type'  => 'raw',
                'label' => '',
                'value' => function($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<span class="btn btn-xs red" style="margin-bottom: 1px; margin-top: 1px"><span class="fa fa-times"></span></span>', '#', [
                            'title'   => Yii::t('app', 'Delete'),
                            'onClick' => 'delRowOrderItem(' . $key . '); return false;',
                            'id'      => 'order-item-del-btn',
                        ]);
                },
            ],
        ],
        'gridSettings'      => [
            'panel' => [
                'heading' => false,
                'type'    => GridView::TYPE_DEFAULT,
                'before'  => false,
                'footer'  => false,
                'after'   => Html::button('<i class="glyphicon glyphicon-plus"></i>' . t('app', 'Add Order Item'), [
                    'type'    => 'button',
                    'class'   => 'btn btn-success kv-batch-create',
                    'onClick' => 'addRowOrderItem()',
                ]),
            ],
        ],
    ]);
    echo "    </div>\n\n";
    ?>

