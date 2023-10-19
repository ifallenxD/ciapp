<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeSectionDivisionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                //give me examples
                'office_section_division' => 'Office of the President',
                'code' => 'OP',
                'description' => 'Office of the President',
            ], 
            [
                'office_section_division' => 'Office of the Vice President',
                'code' => 'OVP',
                'description' => 'Office of the Vice President',
            ],
            [
                'office_section_division' => 'Office of the Secretary',
                'code' => 'OSEC',
                'description' => 'Office of the Secretary',
            ],
            [
                'office_section_division' => 'Office of the Undersecretary',
                'code' => 'OUS',
                'description' => 'Office of the Undersecretary',
            ],
            [
                'office_section_division' => 'Office of the Assistant Secretary',
                'code' => 'OAS',
                'description' => 'Office of the Assistant Secretary',
            ],
            [
                'office_section_division' => 'Office of the Director',
                'code' => 'OD',
                'description' => 'Office of the Director',
            ]
        ];

        $this->db->table('office_section_divisions')->insertBatch($data);
    }
}
