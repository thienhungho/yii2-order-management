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

    public static $all_status = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'transport' => 'Transport',
        'success' =>  'Success',
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
            [['include_vat'], 'string', 'max' => 10]
        ]);
    }
	
}
