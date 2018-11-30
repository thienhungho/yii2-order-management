<?php

namespace thienhungho\OrderManagement\modules\OrderBase\base;

use thienhungho\ProductManagement\models\Product;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
 * @property \thienhungho\ProductManagement\models\Product $product0
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
            [['order', 'product', 'quantity'], 'required'],
            [['order', 'product', 'created_by', 'updated_by'], 'integer'],
            [['product_price', 'total_price', 'quantity', 'real_value', 'discount_value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['coupon', 'product_unit', 'currency_unit'], 'string', 'max' => 255]
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
            'total_price' => Yii::t('app', 'Total Price'),
            'real_value' => Yii::t('app', 'Real Value'),
            'discount_value' => Yii::t('app', 'Discount Value'),
            'coupon' => Yii::t('app', 'Coupon'),
            'product_unit' => Yii::t('app', 'Product Unit'),
            'currency_unit' => Yii::t('app', 'Currency Unit'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder0()
    {
        return $this->hasOne(\thienhungho\OrderManagement\models\Order::className(), ['id' => 'order']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product']);
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
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
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
