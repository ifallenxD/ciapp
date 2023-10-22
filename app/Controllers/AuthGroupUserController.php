<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;


class AuthGroupUserController extends BaseController
{
    public function index()
    {
         // Get all the roles from AuthGroups.php config file and display them in a table 
         $data = config('AuthGroups')->groups;
         $data = [
             'roles' => $data
         ];
         return view('roles/index', $data);
    }

    public function changeRole($id)
    {
        $authGroupUser = new \App\Models\AuthGroupUser();
        // get data from request JSON object 
        $data = $this->request->getJSON();
        
        if (!$authGroupUser -> validate($data)){
            $response = array(
                "status" => "error",
                "message" => $authGroupUser->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        
        $data = [
            'user_id' => (int)$id, // 'user_id' => $data->user_id, // 'user_id' => $id,
            'group' => $data->group,
        ];

        // return $this->response->setJSON($data)->setStatusCode(Response::HTTP_OK);

        $authGroupUserID = $authGroupUser->where('user_id', $id)->first();
        
        $authGroupUser->update($authGroupUserID['id'], $data);
       
        if ($authGroupUser->errors()){
            $response = array(
                "status" => "error",
                "message" => $authGroupUser->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response = array(
            "status" => "success",
            "message" => "User updated successfully",
            "token" => csrf_hash() // New token hash
        );
        
        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
    }
}
