<div class="form-group" id="add-order-item">
    <?php

    use kartik\builder\TabularForm;
    use thienhungho\Widgets\models\GridView;
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
            "id"                  => [
                'type'          => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true],
            ],
            'product_feature_img' => [
                'label' => Yii::t('app', 'Feature Img'),
                'type'  => TabularForm::INPUT_RAW,
                'value' => function($model, $key) {
                    if (!empty($model['product'])) {
                        $product = \thienhungho\ProductManagement\models\Product::find()
                            ->select('feature_img')
                            ->where(['id' => $model['product']])
                            ->asArray()
                            ->one();

                        return html_img('/' . get_other_img_size_path('thumbnail', $product['feature_img']), ['style' => 'max-width: 100px']);
                    }

                    return html_img('/' . DEFAULT_FEATURE_IMG, ['style' => 'max-width: 100px']);
                },
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
            'product'             => [
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
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
            'quantity'            => [
                'label'       => Yii::t('app', 'Quantity'),
                'type'  => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'suffix' => '',
                        'digits' => 2,
                    ],
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
            'product_unit'        => [
                'label' => Yii::t('app', 'Product Unit'),
                'type'  => TabularForm::INPUT_RAW,
                'value' => function($model, $key) {
                    if (!empty($model['product_unit'])) {
                        return $model['product_unit'];
                    }
                    if (!empty($model['product'])) {
                        $product = \thienhungho\ProductManagement\models\Product::find()
                            ->select('unit')
                            ->where(['id' => $model['product']])
                            ->asArray()
                            ->one();

                        return $product['unit'];
                    }

                    return null;
                },
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
            'product_price'       => [
                'label'       => Yii::t('app', 'Product Price'),
                'type'        => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'suffix' => '',
                        'digits' => 2,
                    ],
                    'readonly'           => true,
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
                'pageSummary'   => Yii::t('app', 'Total'),
            ],
            'real_value'          => [
                'label'       => Yii::t('app', 'Real Value'),
                'type'        => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'suffix' => '',
                        'digits' => 2,
                    ],
                    'readonly'           => true,
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
                'pageSummary'   => true,
            ],
            'discount_value'      => [
                'label'       => Yii::t('app', 'Discount Value'),
                'type'        => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'suffix' => '',
                        'digits' => 2,
                    ],
                    'readonly'           => true,
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
                'pageSummary'   => true,
            ],
            'total_price'         => [
                'label'       => Yii::t('app', 'Total Price'),
                'type'        => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\number\NumberControl::classname(),
                'options'     => [
                    'maskedInputOptions' => [
                        'prefix' => '',
                        'suffix' => '',
                        'digits' => 2,
                    ],
                    'readonly'           => true,
                    'displayOptions'     => ['class' => 'form-control kv-monospace'],
                    'saveInputContainer' => ['class' => 'kv-saved-cont'],
                ],
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
                'pageSummary'   => true,
            ],
            'currency_unit'       => [
                'type'  => TabularForm::INPUT_HIDDEN_STATIC,
                'label' => Yii::t('app', 'Currency Unit'),
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
            //            'coupon'         => [
            //                'type'  => TabularForm::INPUT_TEXT,
            //                'label' => Yii::t('app', 'Coupon'),
            //            ],
            'del'                 => [
                'type'  => TabularForm::INPUT_RAW,
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
                'columnOptions' => ['vAlign' => GridView::ALIGN_MIDDLE],
            ],
        ],
        'gridSettings'      => [
            'responsiveWrap' => false,
            'condensed'      => true,
            'hover'          => true,
            'panel'          => [
                'heading' => true,
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

