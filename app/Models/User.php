<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'status',
        'status_message',
        'active',
        'secret', //email
        'group', 
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username' => 'required|min_length[3]|max_length[255]',
        'status' => 'required|min_length[3]|max_length[255]',
        'status_message' => 'required|min_length[3]|max_length[255]',
        'active' => 'required|min_length[1]|max_length[1]|integer',
        'group' => 'required|min_length[3]|max_length[20]',
    ];
    protected $validationMessages   = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must have at least 3 characters',
            'max_length' => 'Username must have at most 255 characters',
        ],
        'status' => [
            'required' => 'Status is required',
            'min_length' => 'Status must have at least 3 characters',
            'max_length' => 'Status must have at most 255 characters',
        ],
        'status_message' => [
            'required' => 'Status message is required',
            'min_length' => 'Status message must have at least 3 characters',
            'max_length' => 'Status message must have at most 255 characters',
        ],
        'active' => [
            'required' => 'Active is required',
            'min_length' => 'Active must have at least 1 character',
            'max_length' => 'Active must have at most 1 character',
            'integer' => 'Active must be an integer',
        ],
        'group' => [
            'required' => 'Group is required',
            'min_length' => 'Group must have at least 3 characters',
            'max_length' => 'Group must have at most 20 characters',
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
