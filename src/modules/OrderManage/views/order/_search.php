<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\OrderManagement\modules\OrderManage\search\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'placeholder' => 'Status']) ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true, 'placeholder' => 'Payment Method']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'include_vat')->textInput(['maxlength' => true, 'placeholder' => 'Include Vat']) ?>

    <?php /* echo $form->field($model, 'customer_username')->textInput(['maxlength' => true, 'placeholder' => 'Customer Username']) */ ?>

    <?php /* echo $form->field($model, 'customer_phone')->textInput(['maxlength' => true, 'placeholder' => 'Customer Phone']) */ ?>

    <?php /* echo $form->field($model, 'customer_name')->textInput(['maxlength' => true, 'placeholder' => 'Customer Name']) */ ?>

    <?php /* echo $form->field($model, 'customer_email')->textInput(['maxlength' => true, 'placeholder' => 'Customer Email']) */ ?>

    <?php /* echo $form->field($model, 'customer_address')->textInput(['maxlength' => true, 'placeholder' => 'Customer Address']) */ ?>

    <?php /* echo $form->field($model, 'customer_company')->textInput(['maxlength' => true, 'placeholder' => 'Customer Company']) */ ?>

    <?php /* echo $form->field($model, 'customer_area')->textInput(['maxlength' => true, 'placeholder' => 'Customer Area']) */ ?>

    <?php /* echo $form->field($model, 'customer_tax_number')->textInput(['maxlength' => true, 'placeholder' => 'Customer Tax Number']) */ ?>

    <?php /* echo $form->field($model, 'ref_by')->textInput(['placeholder' => 'Ref By']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
