<?php

namespace thienhungho\OrderManagement\migrations;

use yii\db\Schema;

class m181112_090101_order extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}', [
            'id'                  => $this->primaryKey(),
            'status'              => $this->string(255)->defaultValue('pending'),
            'payment_method'      => $this->string(255)->defaultValue('COD'),
            'note'                => $this->text(),
            'include_vat'         => $this->string(10)->defaultValue('No'),
            'customer_username'   => $this->string(255),
            'customer_phone'      => $this->string(255)->notNull(),
            'customer_name'       => $this->string(255)->notNull(),
            'customer_email'      => $this->string(255),
            'customer_address'    => $this->string(255)->notNull(),
            'customer_company'    => $this->string(255),
            'customer_area'       => $this->string(255),
            'customer_tax_number' => $this->string(255),
            'ref_by'              => $this->integer(19),
            'created_at'          => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at'          => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by'          => $this->integer(19),
            'updated_by'          => $this->integer(19),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
