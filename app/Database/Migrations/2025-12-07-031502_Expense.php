<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Expense extends Migration
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
            'expencePurpose' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'expenser_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'expense_date' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);

        $this->forge->createTable('expenses');
    }

    public function down()
    {
        $this->forge->dropTable('expenses');
    }
}
