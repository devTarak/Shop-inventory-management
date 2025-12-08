<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SellProduct extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_sku' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'product_buying_price' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
            ],
            'selling_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('sales');
    }

    public function down()
    {
        $this->forge->dropTable('sales', true);
    }
}
