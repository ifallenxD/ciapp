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
                'description' => 'Office of the President',
            ], 
            [
                'office_section_division' => 'Office of the Vice President',
                'description' => 'Office of the Vice President',
            ],
            [
                'office_section_division' => 'Office of the Secretary',
                'description' => 'Office of the Secretary',
            ],
            [
                'office_section_division' => 'Office of the Undersecretary',
                'description' => 'Office of the Undersecretary',
            ],
            [
                'office_section_division' => 'Office of the Assistant Secretary',
                'description' => 'Office of the Assistant Secretary',
            ],
            [
                'office_section_division' => 'Office of the Director',
                'description' => 'Office of the Director',
            ]
        ];

        $this->db->table('office_section_division')->insertBatch($data);
    }
}
