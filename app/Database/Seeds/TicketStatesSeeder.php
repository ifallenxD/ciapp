<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TicketStatesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'state' => 'Pending',
                'description' => 'Pending',
            ],
            [
                'state' => 'Processing',
                'description' => 'Processing',
            ],
            [
                'state' => 'Resolved',
                'description' => 'Resolved',
            ],
        ];

        $this->db->table('ticket_states')->insertBatch($data);
    }
}
