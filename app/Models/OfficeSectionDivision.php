<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeSectionDivision extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'office_section_divisions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'office_section_division',
        'code',
        'description',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'office_section_division' => 'required|min_length[3]|max_length[255]',
        'code' => 'required|min_length[2]|max_length[20]',
        'description' => 'required|min_length[3]|max_length[255]',
    ];
    protected $validationMessages   = [
        'office_section_division' => [
            'required' => 'Office Section Division is required',
            'min_length' => 'Office Section Division must have at least 3 characters in length',
            'max_length' => 'Office Section Division must not exceed 255 characters in length',
        ],
        'code' => [
            'required' => 'Code is required',
            'min_length' => 'Code must have at least 2 characters in length',
            'max_length' => 'Code must not exceed 20 characters in length',
        ],
        'description' => [
            'required' => 'Description is required',
            'min_length' => 'Description must have at least 3 characters in length',
            'max_length' => 'Description must not exceed 255 characters in length',
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
