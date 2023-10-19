<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {   
        $user = new \App\Models\User();
        $totalusers = $user->select('id')->countAllResults();
        $totalactiveusers = $user->select('id')->where('active', 1)->countAllResults();
        $users = $user->select("users.*, auth_groups_users.group, auth_identities.secret")
        ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
        ->join('auth_identities', 'auth_identities.user_id = users.id')
        ->orderBy('users.id', 'DESC')
        ->findAll();

        //replace secret array key in $users with email
        foreach($users as $key => $user){
            $users[$key]['email'] = $user['secret'];
            unset($users[$key]['secret']);
        }

        $data = [
            'totalusers' => $totalusers,
            'totalactiveusers' => $totalactiveusers,
            'users' => $users
        ];
        
        return view('user/index', $data);
    }

    public function update(){
        $user = new \App\Models\User();
        $request = service('request');
        $postData = $request->getPost();

        $data = [
            'username' => $postData['username'],
            'status' => $postData['status'],
            'status_message' => $postData['status_message'],
            'active' => $postData['active'],
            'secret' => $postData['email'],
            'group' => $postData['group'],
        ];

        $user->update($postData['id'], $data);

        $response = array(
            "status" => "success",
            "message" => "User updated successfully",
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }

    public function delete(){
        $user = new \App\Models\User();
        $request = service('request');
        $postData = $request->getPost();

        $user->delete($postData['id']);

        $response = array(
            "status" => "success",
            "message" => "User deleted successfully",
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }






    
    public function getall()
    {
        $user = new \App\Models\User();

        ## Total number of records without filtering   
        $totalRecords = $user->select('id')->countAllResults();

        // $users = $user->findAll();
        $users = $user->select("users.*, auth_groups_users.group, auth_identities.secret")
        ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
        ->join('auth_identities', 'auth_identities.user_id = users.id')
        ->orderBy('users.id', 'DESC')
        ->findAll();
        
        //replace secret array key in $users with email
        foreach($users as $key => $user){
            $users[$key]['email'] = $user['secret'];
            unset($users[$key]['secret']);
        }

        $response = array(
            "data" => $users,
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response);
    }
}
