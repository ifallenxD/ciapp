<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class OfficeSectionDivisionController extends BaseController
{
    public function index()
    {
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $totaloffice_section_division = $office_section_division->select('id')->countAllResults();

        $data = [
            'total_office_section_division' => $totaloffice_section_division
        ];
        return view('offices/index',$data);
    }

    public function getall()
    {
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $all_office_section_division = $office_section_division->findAll();
        $data = [
            'status' => 'success',
            'data' => $all_office_section_division,
            'message' => 'Successfully retrieved all office section division.',
            'token' => csrf_hash()

        ];
        return $this->response->setJSON($data)->setStatusCode(200);
    }

    public function insert(){
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $data = $this->request->getJSON();
     
        if (!$office_section_division->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $office_section_division->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        //change keys OfficeID to id, OfficeName to office_section_division, OfficeCode to code, OfficeDescription to description
        $data = [
            'office_section_division' => $data->AddOfficeName,
            'code' => $data->AddOfficeCode,
            'description' => $data->AddOfficeDescription,
        ]; 

        $office_section_division->insert($data);

        if ($office_section_division->errors()) {
            $response = [
                'status' => 'error',
                'data' => $office_section_division->errors(),
                'message' => 'Failed to insert office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Successfully inserted office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
        }
    }

    public function update(){
        
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $data = $this->request->getJSON();
        $id = $data->EditOfficeID;

        if (!$office_section_division->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $office_section_division->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        //change keys OfficeID to id, OfficeName to office_section_division, OfficeCode to code, OfficeDescription to description
        $data = [
            'office_section_division' => $data->EditOfficeName,
            'code' => $data->EditOfficeCode,
            'description' => $data->EditOfficeDescription,
        ]; 
            
        $office_section_division->update($id, $data);
        
        if ($office_section_division->errors()) {
            $response = [
                'status' => 'error',
                'data' => $office_section_division->errors(),
                'message' => 'Failed to update office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Successfully updated office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
        }
    }

    public function delete($id){
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $office_section_division->delete($id);
        if ($office_section_division->errors()) {
            $response = [
                'status' => 'error',
                'data' => $office_section_division->errors(),
                'message' => 'Failed to delete office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Successfully deleted office section division.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
        }
    }
}
