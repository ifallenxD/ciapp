<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OfficeSectionDivision extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'office_section_division' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id');
        $this->forge->addForeignKey('modified_by', 'users', 'id');
        $this->forge->createTable('office_section_divisions');
    }

    public function down()
    {
        $this->forge->dropTable('office_section_divisions');
    }
}
