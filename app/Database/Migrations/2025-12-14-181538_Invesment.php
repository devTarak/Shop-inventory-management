<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invesment extends Migration
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
            'investor_id' => [
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'invest_date' => [
                'type' => 'DATE',
            ],
            'note' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('investor_name', 'investators_persons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('investrators');
    }

    public function down()
    {
        $this->forge->dropTable('investrators');
    }
}
