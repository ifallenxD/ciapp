<?php

namespace App\Models;

use CodeIgniter\Model;

class Ticket extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'remarks',
        'first_name',
        'last_name',
        'email',
        'description',
        'ticket_state_id',
        'ticket_category_id',
        'office_section_division_id',
        'created_by',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'modified_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'description' => 'required',
        'ticket_state_id' => 'required',
        'ticket_category_id' => 'required',
        'office_section_division_id' => 'required',
        'created_by' => 'required',
    ];
    protected $validationMessages   = [
        'first_name' => [
            'required' => 'First name is required',
        ],
        'last_name' => [
            'required' => 'Last name is required',
        ],
        'email' => [
            'required' => 'Email is required',
        ],
        'description' => [
            'required' => 'Description is required',
        ],
        'ticket_state_id' => [
            'required' => 'Ticket state is required',
        ],
        'ticket_category_id' => [
            'required' => 'Ticket category is required',
        ],
        'office_section_division_id' => [
            'required' => 'Office/Section/Division is required',
        ],
        'created_by' => [
            'required' => 'Created by is required',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
