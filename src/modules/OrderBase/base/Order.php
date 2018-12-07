<?php

namespace thienhungho\OrderManagement\modules\OrderBase\base;

use thienhungho\UserManagement\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "{{%order}}".
 *
 * @property integer $id
 * @property string $status
 * @property string $payment_method
 * @property string $note
 * @property string $include_vat
 * @property string $customer_username
 * @property string $customer_phone
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_address
 * @property string $customer_company
 * @property string $customer_area
 * @property string $customer_tax_number
 * @property integer $ref_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\OrderManagement\modules\OrderBase\OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'orderItems',
            'refBy0'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note'], 'string'],
            [['customer_phone', 'customer_name', 'customer_address', 'delivery_address'], 'required'],
            [['ref_by', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'payment_method', 'customer_username', 'customer_phone', 'customer_name', 'customer_email', 'customer_address', 'customer_company', 'customer_area', 'customer_tax_number', 'delivery_address'], 'string', 'max' => 255],
            [['total_price', 'real_value', 'discount_value'], 'number'],
            [['total_price', 'real_value', 'discount_value'], 'default', 'value' => 0, 'on' => 'insert'],
            [['include_vat'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'note' => Yii::t('app', 'Note'),
            'include_vat' => Yii::t('app', 'Include Vat'),
            'customer_username' => Yii::t('app', 'Customer Username'),
            'customer_phone' => Yii::t('app', 'Customer Phone'),
            'customer_name' => Yii::t('app', 'Customer Name'),
            'customer_email' => Yii::t('app', 'Customer Email'),
            'customer_address' => Yii::t('app', 'Customer Address'),
            'customer_company' => Yii::t('app', 'Customer Company'),
            'customer_area' => Yii::t('app', 'Customer Area'),
            'customer_tax_number' => Yii::t('app', 'Customer Tax Number'),
            'ref_by' => Yii::t('app', 'Ref By'),
            'total_price' => Yii::t('app', 'Total Price'),
            'real_value' => Yii::t('app', 'Real Value'),
            'discount_value' => Yii::t('app', 'Discount Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'delivery_address' => Yii::t('app', 'Delivery Address'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(\thienhungho\OrderManagement\models\OrderItem::className(), ['order' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'ref_by']);
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
     * @return \thienhungho\OrderManagement\modules\OrderBase\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \thienhungho\OrderManagement\modules\OrderBase\query\OrderQuery(get_called_class());
    }
}
