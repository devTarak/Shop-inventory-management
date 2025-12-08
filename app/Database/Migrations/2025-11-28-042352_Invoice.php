<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invoice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'invoice_number'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'Customer_id'       => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
            ],
            'Sold_intem_id'       => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('Customer_id', 'customers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('Sold_intem_id', 'sales', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sell_log');
    }

    public function down()
    {
        $this->forge->dropTable('sell_log');
    }
}
