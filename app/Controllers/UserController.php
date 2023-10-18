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
        $users = $user->findAll();

        $data = [
            'totalusers' => $totalusers,
            'totalactiveusers' => $totalactiveusers,
            'users' => $users
        ];
    
        return view('user/index', $data);
    }

    public function getall()
    {
        $user = new \App\Models\User();
        // $request = service('request');
        // $postData = $request->getPost();
    

        // ## Read value
        // $draw = $postData['draw'];
        // $start = $postData['start'];
        // $rowperpage = $postData['length']; // Rows display per page
        // $searchValue = $post6y77777yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyData['search']['value']; // Search value

        ## Total number of records without filtering   
        $totalRecords = $user->select('id')->countAllResults();

        ## Total number of records with filtering
        // $totalRecordwithFilter = $user->select('*')
        // ->like('username', $searchValue)
        // ->orLike('status', $searchValue)
        // ->orLike('status_message', $searchValue)
        // ->orLike('active', $searchValue)
        // ->countAllResults();

        // ## Fetch records
        // $users = $user->select('id, username, status, status_message, active')
        // ->like('username', $searchValue)
        // ->orLike('status', $searchValue)
        // ->orLike('status_message', $searchValue)
        // ->orLike('active', $searchValue)
        // ->orderBy('id', 'DESC')
        // ->limit($rowperpage, $start)
        // ->findAll();

        $users = $user->findAll();
        
        // $data = array();

        // foreach($users as $user){
        //     $data[] = array(
        //         "id" => $user['id'],
        //         "username" => $user['username'],
        //         "status" => $user['status'],
        //         "status_message" => $user['status_message'],
        //         "active" => $user['active'],
        //     );
        // }

        $response = array(
            "data" => $users,
            "token" => csrf_hash() // New token hash
        );

        // $response = array(
        //     "draw" => intval($draw),
        //     "recordsTotal" => $totalRecords,
        //     "recordsFiltered" => $totalRecordwithFilter,
        //     "data" => $data,
        //     "token" => csrf_hash() // New token hash
        // );

        return $this->response->setJSON($response);
    }
}
