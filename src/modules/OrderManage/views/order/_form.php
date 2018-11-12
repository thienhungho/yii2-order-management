<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderBase\Order */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'OrderItem', 
        'relID' => 'order-item', 
        'value' => \yii\helpers\Json::encode($model->orderItems),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'placeholder' => 'Status']) ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true, 'placeholder' => 'Payment Method']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'include_vat')->textInput(['maxlength' => true, 'placeholder' => 'Include Vat']) ?>

    <?= $form->field($model, 'customer_username')->textInput(['maxlength' => true, 'placeholder' => 'Customer Username']) ?>

    <?= $form->field($model, 'customer_phone')->textInput(['maxlength' => true, 'placeholder' => 'Customer Phone']) ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true, 'placeholder' => 'Customer Name']) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true, 'placeholder' => 'Customer Email']) ?>

    <?= $form->field($model, 'customer_address')->textInput(['maxlength' => true, 'placeholder' => 'Customer Address']) ?>

    <?= $form->field($model, 'customer_company')->textInput(['maxlength' => true, 'placeholder' => 'Customer Company']) ?>

    <?= $form->field($model, 'customer_area')->textInput(['maxlength' => true, 'placeholder' => 'Customer Area']) ?>

    <?= $form->field($model, 'customer_tax_number')->textInput(['maxlength' => true, 'placeholder' => 'Customer Tax Number']) ?>

    <?= $form->field($model, 'ref_by')->textInput(['placeholder' => 'Ref By']) ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(t('app', 'OrderItem')),
            'content' => $this->render('_formOrderItem', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->orderItems),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if(Yii::$app->controller->action->id != 'create'): ?>
        <?= Html::submitButton(t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
        <?= Html::a(t('app', 'Cancel'), request()->referrer , ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
