<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tickets extends Migration
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
            'ticket_state_id' => [ // PENDING, PROCESSING, RESOLVED
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                // 'references' => 'ticket_states(id)',
            ],
            'remarks' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'office/section/division_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                // 'references' => 'office_section_division(id)',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ticket_category_id' => [ // SEVERITY
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                // 'references' => 'ticket_category(id)',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                // 'references' => 'users(id)',
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                // 'references' => 'users(id)',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'modified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ticket_state_id', 'ticket_states', 'id');
        $this->forge->addForeignKey('office/section/division_id', 'office_section_divisions', 'id');
        $this->forge->addForeignKey('ticket_category_id', 'ticket_categories', 'id');
        $this->forge->addForeignKey('created_by', 'users', 'id');
        $this->forge->addForeignKey('modified_by', 'users', 'id');
        $this->forge->createTable('tickets');
        
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
