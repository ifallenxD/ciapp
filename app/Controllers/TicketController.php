<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class TicketController extends BaseController
{
    public function index()
    {
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $ticket_category = new \App\Models\TicketCategory();
        $ticket_state = new \App\Models\TicketState();
        
        $all_office_section_division = $office_section_division->findAll();
        $all_ticket_categories = $ticket_category->findAll();
        $all_ticket_states = $ticket_state->findAll();
        
        $data = [
            'offices' => $all_office_section_division,
            'ticket_categories' => $all_ticket_categories,
            'ticket_states' => $all_ticket_states,
        ];    

        return view('tickets/index', $data);
    }

    public function insert(){
        $ticket = new \App\Models\Ticket();
        $data = $this->request->getJSON();
        // // get current user id using auth()->user()->id
        // $currentUser = auth()->user()->id;

        if (!$ticket->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $ticket->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        // trim the data to remove whitespaces before and after the string value of the data 
        
        $data = [
            'first_name' => $data->AddFirstName,
            'last_name' => $data->AddLastName,
            'email' => $data->AddEmail,
            'description' => $data->AddDescription,
            'ticket_state_id' => $data->AddTicketStateID,
            'office_section_division_id' => $data->AddOfficeSectionDivisionID,
            'ticket_category_id' => $data->AddTicketCategoryID,
            'created_by' => $data->CurrentUserID,
        ];

        $ticket->insert($data);

        if ($ticket->errors()) {
            $response = [
                'status' => 'error',
                'data' => $ticket->errors(),
                'message' => 'Failed to create ticket.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response = [
            'status' => 'success',
            'data' => $ticket->getInsertID(),
            'message' => 'Successfully created ticket.',
            'token' => csrf_hash()
        ];

        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function getall(){
        $ticket = new \App\Models\Ticket();

        $users = auth()->getProvider();
        $current_user_id = auth()->user()->id;

        $current_user = $users->findById($current_user_id);
        // get the group name of the current user
        $current_user_group = $current_user->getGroups();

        if ($current_user_group[0] == 'admin') {
            $all_tickets = $ticket
            -> select('tickets.id, tickets.first_name, tickets.last_name, tickets.email, tickets.description, ticket_states.state as ticket_state, ticket_states.id as ticket_state_id, office_section_divisions.office_section_division as office_section_division, office_section_divisions.id as office_section_division_id, ticket_categories.ticket_category as ticket_category, ticket_categories.id as ticket_category_id, users.username as created_by, tickets.created_at, tickets.modified_at, tickets.remarks')
            -> join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            -> join('office_section_divisions', 'office_section_divisions.id = tickets.office_section_division_id')
            -> join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            -> join('users', 'users.id = tickets.created_by')
            ->findAll();
        }  else {
            $all_tickets = $ticket
            -> select('tickets.id, tickets.first_name, tickets.last_name, tickets.email, tickets.description, ticket_states.state as ticket_state, ticket_states.id as ticket_state_id, office_section_divisions.office_section_division as office_section_division, office_section_divisions.id as office_section_division_id, ticket_categories.ticket_category as ticket_category, ticket_categories.id as ticket_category_id, users.username as created_by, tickets.created_at, tickets.modified_at, tickets.remarks')
            -> join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            -> join('office_section_divisions', 'office_section_divisions.id = tickets.office_section_division_id')
            -> join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            -> join('users', 'users.id = tickets.created_by')
            -> where('users.id', $current_user_id)
            ->findAll();
        }

        

        $data = [
            'status' => 'success',
            'data' => $all_tickets,
            'message' => 'Successfully retrieved all tickets.',
            'token' => csrf_hash(),

        ];
        return $this->response->setJSON($data)->setStatusCode(200);
    }

    public function update(){
        $ticket = new \App\Models\Ticket();
        $data = $this->request->getJSON();
        // // get current user id using auth()->user()->id
        // $currentUser = auth()->user()->id;

        if (!$ticket->validate($data)) {
            $response = array(
                "status" => "error",
                "message" => $ticket->errors(),
                "token" => csrf_hash()
            );
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $id = $data->EditTicketID;
        $data = [
            'first_name' => $data->EditFirstName,
            'last_name' => $data->EditLastName,
            'email' => $data->EditEmail,
            'description' => $data->EditDescription,
            'ticket_state_id' => $data->EditTicketStateID,
            'office_section_division_id' => $data->EditOfficeSectionDivisionID,
            'ticket_category_id' => $data->EditTicketCategoryID,
            'modified_by' => $data->EditCurrentUserID,
            'modified_at' => date('Y-m-d H:i:s'),
            'remarks' => $data->EditRemarks
        ];

        $ticket->update($id, $data);

        if ($ticket->errors()) {
            $response = [
                'status' => 'error',
                'data' => $ticket->errors(),
                'message' => 'Failed to update ticket.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response = [
            'status' => 'success',
            'data' => $ticket->getInsertID(),
            'message' => 'Successfully updated ticket.',
            'token' => csrf_hash()
        ];

        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function delete($id){
        $ticket = new \App\Models\Ticket();
        $ticket->delete($id);

        if ($ticket->errors()) {
            $response = [
                'status' => 'error',
                'data' => $ticket->errors(),
                'message' => 'Failed to delete ticket.',
                'token' => csrf_hash()
            ];
            return $this->response->setJSON($response)->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response = [
            'status' => 'success',
            'data' => $id,
            'message' => 'Successfully deleted ticket.',
            'token' => csrf_hash()
        ];

        return $this->response->setJSON($response)->setStatusCode(Response::HTTP_OK);
    }


}
