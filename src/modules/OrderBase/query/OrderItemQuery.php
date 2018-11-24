<?php

namespace thienhungho\OrderManagement\modules\OrderBase\query;

/**
 * This is the ActiveQuery class for [[OrderItem]].
 *
 * @see OrderItem
 */
class OrderItemQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return OrderItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
