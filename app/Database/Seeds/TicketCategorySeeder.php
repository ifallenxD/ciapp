<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'ticket_category' => 'Low',
                'description' => 'Low',
            ],
            [
                'ticket_category' => 'Medium',
                'description' => 'Medium',
            ],
            [
                'ticket_category' => 'High',
                'description' => 'High',
            ],
            [
                'ticket_category' => 'Critical',
                'description' => 'Critical',
            ],
        ];

        $this->db->table('ticket_category')->insertBatch($data);
    }
}
