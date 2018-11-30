<?php

namespace thienhungho\OrderManagement\modules\OrderBase;

use Yii;
use \thienhungho\OrderManagement\modules\OrderBase\base\Order as BaseOrder;

/**
 * This is the model class for table "order".
 */
class Order extends BaseOrder
{
    const STATUS_SUCCESS = 'success';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_TRANSPORT = 'transport';

    const PAYMENT_MEDTHOD_COD = 'cod';
    const PAYMENT_MEDTHOD_CASH = 'cash';
    const PAYMENT_MEDTHOD_ONLINE_BANKING = 'online banking';
    const PAYMENT_MEDTHOD_PAYPAL = 'paypal';
    const PAYMENT_MEDTHOD_VISA = 'visa';
    const PAYMENT_MEDTHOD_MASTER_CARD = 'master card';

    public static $all_status = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'transport' => 'Transport',
        'success' =>  'Success',
    ];

    public static $all_payment_method = [
        'cod' => 'COD',
        'cash' => 'CASH',
        'online banking' => 'Online Banking',
        'paypal' => 'Paypal',
        'visa' => 'Visa',
        'master card' => 'Master Card'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['note'], 'string'],
            [['customer_phone', 'customer_name', 'customer_address'], 'required'],
            [['ref_by', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'payment_method', 'customer_username', 'customer_phone', 'customer_name', 'customer_email', 'customer_address', 'customer_company', 'customer_area', 'customer_tax_number'], 'string', 'max' => 255],
            [['include_vat'], 'string', 'max' => 10],
            [['created_by'], 'default', 'value' => get_current_user_id()]
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
            if (!$this->isNewRecord) {
                $this->total_price = \thienhungho\OrderManagement\models\OrderItem::find()
                    ->where(['order' => $this->id])
                    ->sum('total_price');
                $this->real_value = \thienhungho\OrderManagement\models\OrderItem::find()
                    ->where(['order' => $this->id])
                    ->sum('real_value');
                $this->discount_value = \thienhungho\OrderManagement\models\OrderItem::find()
                    ->where(['order' => $this->id])
                    ->sum('discount_value');
            }

            return true;
        }

        return false;
    }

}
