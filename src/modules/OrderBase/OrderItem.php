<?php

namespace thienhungho\OrderManagement\modules\OrderBase;

use Yii;
use \thienhungho\OrderManagement\modules\OrderBase\base\OrderItem as BaseOrderItem;

/**
 * This is the model class for table "order_item".
 */
class OrderItem extends BaseOrderItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['order', 'product', 'product_price', 'quantity'], 'required'],
            [['order', 'product', 'quantity', 'created_by', 'updated_by'], 'integer'],
            [['product_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupon'], 'string', 'max' => 255]
        ]);
    }
	
}
