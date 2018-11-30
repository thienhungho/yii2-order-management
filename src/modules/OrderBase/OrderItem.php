<?php

namespace thienhungho\OrderManagement\modules\OrderBase;

use thienhungho\ProductManagement\models\Product;
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
            [['order', 'product', 'quantity'], 'required'],
            [['order', 'product', 'created_by', 'updated_by'], 'integer'],
            [['product_price', 'total_price', 'quantity', 'real_value', 'discount_value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupon', 'product_unit', 'currency_unit'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->coupon = null;

            if ($this->isNewRecord) {
                $this->product_price = $this->product0->promotional_price;
                $this->product_unit = $this->product0->unit;
                $this->currency_unit = $this->product0->currency_unit;
                $orderItem = \thienhungho\OrderManagement\models\OrderItem::find()
                    ->where(['product' => $this->product])
                    ->andWhere(['order' => $this->order])
                    ->one();
                if (!empty($orderItem)) {
                    $this->quantity += $orderItem->quantity;
                    $orderItem->deleteWithRelated();
                }
            }

            $this->real_value = $this->quantity * $this->product_price;
            if ($this->coupon == null) {
                $this->discount_value =  0;
            }
            $this->total_price =  $this->real_value;

            return true;
        }

        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $order = $this->order0;
        $order->total_price = \thienhungho\OrderManagement\models\OrderItem::find()
            ->where(['order' => $this->id])
            ->sum('total_price');
        $order->real_value = \thienhungho\OrderManagement\models\OrderItem::find()
            ->where(['order' => $this->id])
            ->sum('real_value');
        $order->discount_value = \thienhungho\OrderManagement\models\OrderItem::find()
            ->where(['order' => $this->id])
            ->sum('discount_value');
        $order->save();
    }
}
