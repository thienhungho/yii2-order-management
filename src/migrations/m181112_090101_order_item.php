<?php

namespace thienhungho\OrderManagement\migrations;

use yii\db\Schema;

class m181112_090101_order_item extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_item}}', [
            'id'            => $this->primaryKey(),
            'order'         => $this->integer(19)->notNull(),
            'product'       => $this->integer(19)->notNull(),
            'product_price' => $this->float()->notNull(),
            'quantity'      => $this->integer(19)->notNull(),
            'coupon'        => $this->string(255),
            'created_at'    => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at'    => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by'    => $this->integer(19),
            'updated_by'    => $this->integer(19),
            'FOREIGN KEY ([[order]]) REFERENCES {{%order}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[product]]) REFERENCES {{%product}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%order_item}}');
    }
}
