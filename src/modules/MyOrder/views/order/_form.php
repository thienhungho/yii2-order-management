<?php

use kartik\widgets\ActiveForm;
use thienhungho\OrderManagement\models\Order;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */
/* @var $form yii\widgets\ActiveForm */
\mootensai\components\JsBlock::widget([
    'viewFile'   => '_script',
    'pos'        => \yii\web\View::POS_END,
    'viewParams' => [
        'class'       => 'OrderItem',
        'relID'       => 'order-item',
        'value'       => \yii\helpers\Json::encode($model->orderItems),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0,
    ],
]);
?>

<div class="row order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="col-lg-6 col-xs-12">

        <?= $form->field($model, 'customer_username', [
            'addon'        => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
            'hintType'     => \kartik\form\ActiveField::HINT_SPECIAL,
            'hintSettings' => [
                'showIcon' => true,
                'title'    => '<i class="glyphicon glyphicon-info-sign"></i> ' . Yii::t('app', 'Note'),
            ],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(
                \thienhungho\UserManagement\models\User::find()
                    ->orderBy('id')
                    ->asArray()
                    ->all(), 'username', 'username'
            ),
            'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'disabled' => true
        ])->hint(Yii::t('app', 'Choose Customer for this order')) ?>

        <?= $form->field($model, 'customer_phone', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-phone"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Phone'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_name', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Name'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_email', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-envelope"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Email'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_address', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-map-marker"></span>']],
        ])->textarea([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Address'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_company', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-building"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Company'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_area', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-map-marker"></span>']],
        ])->textarea([
            'maxlength'   => true,
            'placeholder' => t('app', 'Customer Area'),
            'readonly' => true
        ]) ?>

        <?= $form->field($model, 'customer_tax_number', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-bank"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => 'Customer Tax Number',
            'readonly' => true
        ]) ?>

    </div>

    <div class="col-lg-6 col-xs-12">

        <?= $form->field($model, 'status', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-eye"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => [
                Order::STATUS_PENDING    => t('app', slug_to_text(Order::STATUS_PENDING)),
                Order::STATUS_PROCESSING => t('app', slug_to_text(Order::STATUS_PROCESSING)),
                Order::STATUS_TRANSPORT  => t('app', slug_to_text(Order::STATUS_TRANSPORT)),
                Order::STATUS_SUCCESS    => t('app', slug_to_text(Order::STATUS_SUCCESS)),
            ],
            'theme'         => \kartik\widgets\Select2::THEME_BOOTSTRAP,
            'options'       => ['placeholder' => t('app', 'Status')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'disabled' => true
        ]) ?>

        <?= $form->field($model, 'payment_method', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-money"></span>']],
        ])->radioButtonGroup([
            Order::PAYMENT_MEDTHOD_CASH           => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_CASH)),
            Order::PAYMENT_MEDTHOD_COD            => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_COD)),
            Order::PAYMENT_MEDTHOD_ONLINE_BANKING => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_ONLINE_BANKING)),
            Order::PAYMENT_MEDTHOD_PAYPAL         => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_PAYPAL)),
            Order::PAYMENT_MEDTHOD_MASTER_CARD    => t('app', slug_to_text(Order::PAYMENT_MEDTHOD_MASTER_CARD)),
        ], [
            'class'       => 'btn-group-sm',
            'itemOptions' => ['labelOptions' => ['class' => 'btn green']],
        ]); ?>

        <?= $form->field($model, 'include_vat', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-money"></span>']],
        ])->radioButtonGroup([
            'yes'          => t('app', slug_to_text('yes')),
            'no'            => t('app', slug_to_text('no')),
        ], [
            'class'       => 'btn-group-sm',
            'itemOptions' => ['labelOptions' => ['class' => 'btn green']],
        ]); ?>

        <?= $form->field($model, 'delivery_address', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-map-marker"></span>']],
        ])->textarea([
            'maxlength'   => true,
            'placeholder' => t('app', 'Delivery Address'),
        ]) ?>

        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    </div>

    <div class="col-lg-12 col-xs-12">

        <?php
        $forms = [
            [
                'label'   => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(t('app', 'OrderItem')),
                'content' => $this->render('_formOrderItem', [
                    'row' => \yii\helpers\ArrayHelper::toArray($model->orderItems),
                ]),
            ],
        ];
        echo kartik\tabs\TabsX::widget([
            'items'         => $forms,
            'position'      => kartik\tabs\TabsX::POS_ABOVE,
            'encodeLabels'  => false,
            'pluginOptions' => [
                'bordered'    => true,
                'sideways'    => true,
                'enableCache' => false,
            ],
        ]);
        ?>
    </div>

    <div class="col-lg-6 col-xs-12">
        <?= $form->field($model, 'real_value', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-money"></span>']],
        ])->widget(\kartik\number\NumberControl::classname(), [
            'value'              => 1000,
            'maskedInputOptions' => [
                'prefix' => '',
                'suffix' => '',
                'digits' => 2,
            ],
            'displayOptions'     => ['class' => 'form-control kv-monospace'],
            'saveInputContainer' => ['class' => 'kv-saved-cont'],
            'readonly'           => true,
        ]) ?>
    </div>

    <div class="col-lg-6 col-xs-12">
        <?= $form->field($model, 'discount_value', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-money"></span>']],
        ])->widget(\kartik\number\NumberControl::classname(), [
            'value'              => 1000,
            'maskedInputOptions' => [
                'prefix' => '',
                'suffix' => '',
                'digits' => 2,
            ],
            'displayOptions'     => ['class' => 'form-control kv-monospace'],
            'saveInputContainer' => ['class' => 'kv-saved-cont'],
            'readonly'           => true,
        ]) ?>
    </div>

    <div class="col-lg-6 col-xs-12">
        <?= $form->field($model, 'total_price', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-money"></span>']],
        ])->widget(\kartik\number\NumberControl::classname(), [
            'value'              => 1000,
            'maskedInputOptions' => [
                'prefix' => '',
                'suffix' => '',
                'digits' => 2,
            ],
            'displayOptions'     => ['class' => 'form-control kv-monospace'],
            'saveInputContainer' => ['class' => 'kv-saved-cont'],
            'readonly'           => true,
        ]) ?>
    </div>

    <div class="col-lg-12 col-xs-12">
        <div class="form-group">
            <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
                <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?><?php endif; ?><?php if (Yii::$app->controller->action->id != 'create'): ?>
                <?= Html::submitButton(t('app', 'Save As New'), [
                    'class' => 'btn btn-info',
                    'value' => '1',
                    'name'  => '_asnew',
                ]) ?><?php endif; ?>
            <?= Html::a(t('app', 'Cancel'), request()->referrer, ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
