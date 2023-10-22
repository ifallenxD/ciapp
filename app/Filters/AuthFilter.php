<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper("auth");
        if (!auth()->loggedIn()) {
            return redirect()->to(base_url('login'));
        }

        $users = auth()->getProvider();
        if (count($users->findAll()) == 1) {
            $db = \Config\Database::connect();
            $builder = $db->table('auth_groups_users');
            $builder->where('user_id', auth()->id());
            $builder->update(['group' => 'admin']);
            $user = auth()->user();
            $user->group = 'admin';
        }
    }
  
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
