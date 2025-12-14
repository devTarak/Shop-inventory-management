<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Investator extends Migration
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
            'investor_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('investators_persons');
    }

    public function down()
    {
        $this->forge->dropTable('investators_persons');
    }
}
