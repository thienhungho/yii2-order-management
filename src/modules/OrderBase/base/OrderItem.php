<?php

namespace thienhungho\OrderManagement\modules\OrderBase\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order
 * @property integer $product
 * @property double $product_price
 * @property integer $quantity
 * @property string $coupon
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\OrderManagement\modules\OrderBase\Order $order0
 * @property \thienhungho\OrderManagement\modules\OrderBase\Product $product0
 */
class OrderItem extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'order0',
            'product0'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'product', 'product_price', 'quantity'], 'required'],
            [['order', 'product', 'quantity', 'created_by', 'updated_by'], 'integer'],
            [['product_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupon'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order' => Yii::t('app', 'Order'),
            'product' => Yii::t('app', 'Product'),
            'product_price' => Yii::t('app', 'Product Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'coupon' => Yii::t('app', 'Coupon'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder0()
    {
        return $this->hasOne(\thienhungho\OrderManagement\modules\OrderBase\Order::className(), ['id' => 'order']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(\thienhungho\OrderManagement\modules\OrderBase\Product::className(), ['id' => 'product']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return \thienhungho\OrderManagement\modules\OrderBase\query\OrderItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \thienhungho\OrderManagement\modules\OrderBase\query\OrderItemQuery(get_called_class());
    }
}
