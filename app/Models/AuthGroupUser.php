<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthGroupUser extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'auth_groups_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'group',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated__at';at';
    // protected $deletedField  = 'deleted

    // Validation
    protected $validationRules      = [
        'user_id' => 'required|min_length[1]|max_length[20]|integer',
        'group' => 'required|min_length[3]|max_length[20]',
    ];
    protected $validationMessages   = [
        'user_id' => [
            'required' => 'User ID is required',
            'min_length' => 'User ID must be at least 1 character in length',
            'max_length' => 'User ID cannot exceed 20 characters in length',
            'integer' => 'User ID must be an integer',
        ],
        'group' => [
            'required' => 'Group is required',
            'min_length' => 'Group must be at least 3 characters in length',
            'max_length' => 'Group cannot exceed 20 characters in length',
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
