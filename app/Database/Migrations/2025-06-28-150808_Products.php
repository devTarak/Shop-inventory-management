<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true,
            ],
            'name' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            ],
            'quantity' => [
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0,
            ],
            'sku' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
            ],
            'buying_price' => [
            'type'       => 'FLOAT',
            'constraint' => '10,2',
            ],
            'created_at' => [
            'type' => 'DATETIME',
            'null' => false,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
