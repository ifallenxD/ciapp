<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class UserController extends BaseController
{
    public function index()
    {   
        $data = $this->getallinfo();
        
        return view('user/index', $data);
    }

    public function getallinfolive(){

        $data = $this->getallinfo();

        return $this->response->setJSON($data);
    }
    private function getallinfo(){
        $user = new \App\Models\User();
        
        $totalusers = $user->select('id')->countAllResults();
        $totalactiveusers = $user->select('id')->where('active', 1)->countAllResults();
        $totalinactiveusers = $user->select('id')->where('active', 0)->countAllResults();

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
            'totalinactiveusers' => $totalinactiveusers,
            'users' => $users
        ];

        return $data;
    }

    public function update(){
        $data = $this->request->getJSON();
        $id = $data->EditUserID;
        
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        $user = $users->findById($id);
        $user->fill([
            'username' => $data->EditUsername,
            'email' => $data->EditEmail,
        ]);

        $users->save($user);

        $response = array(
            "status" => "success",
            "message" => "User updated successfully",
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
    }

    public function changePassword(){
        $data = $this->request->getJSON();
        $id = $data->EditPasswordUserID;
        
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();

        $user = $users->findById($id);
        $user->fill([
            'password' => $data->EditPassword,
        ]);

        $users->save($user);

        $response = array(
            "status" => "success",
            "message" => "User password updated successfully",
            "token" => csrf_hash() // New token hash
        );

        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
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

    public function toggleUserActivityStatus($id){
        $user = new \App\Models\User();
        $data = $this->request->getJSON();

        if (!$user->validate($data)){
            $response = array(
                "status" => "error",
                "message" => $user->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'active' => $data->active,
        ];

        $user->update($id, $data);

        if ($user->errors()){
            $response = array(
                "status" => "error",
                "message" => $user->errors(),
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

    public function toggleUserStatus(){
           // $user = new \App\Models\User();
           $data = $this->request->getJSON();

           if (!$data){
               $response = array(
                   "status" => "error",
                   "message" => "No data received",
                   "token" => csrf_hash()
               );
               return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
           }
   
           $id = $data->EditBanUserID;
           $banMessage = $data->EditBanMessage;
   
           $users = auth()->getProvider();
   
           $user = $users->findById($id);
   
           if ($user->isBanned()) {
               $user->unBan();
               $response_message = "User unbanned successfully";
           } else {
               $user->ban($banMessage);
                $response_message = "User banned successfully";
           }

           if ($user){
                $response = array(
                     "status" => "success",
                     "message" => $response_message,
                     "token" => csrf_hash() // New token hash
                );
    
                return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
              } else {
                $response = array(
                     "status" => "error",
                     "message" => "User not found",
                     "token" => csrf_hash() // New token hash
                );
    
                return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
           }
    }
}
