<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $ticket = new \App\Models\Ticket();
        $ticket_category = new \App\Models\TicketCategory();
        $ticket_state = new \App\Models\TicketState();
        $office_section_division = new \App\Models\OfficeSectionDivision();

        $users = auth()->getProvider();
        $current_user_id = auth()->user()->id;

        $user = $users->findById($current_user_id);
        // get the group name of the current user
        $current_user_group = $user->getGroups();

        if ($current_user_group[0] == 'admin') {
            $all_low_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Low')
            ->countAllResults();
            $all_medium_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Medium')
            ->countAllResults();
            $all_high_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'High')
            ->countAllResults();
            $all_critical_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Critical')
            ->countAllResults();
            $all_tickets_count = $ticket
            ->countAllResults();
            $all_pending_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Pending')
            ->countAllResults();
            $all_processing_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Processing')
            ->countAllResults();
            $all_resolved_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Resolved')
            ->countAllResults();
        } else {
            $all_low_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Low')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_medium_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Medium')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_high_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'High')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_critical_category_tickets_count = $ticket
            ->join('ticket_categories', 'ticket_categories.id = tickets.ticket_category_id')
            ->where('ticket_categories.ticket_category', 'Critical')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_tickets_count = $ticket
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_pending_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Pending')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_processing_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Processing')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
            $all_resolved_tickets_count = $ticket
            ->join('ticket_states', 'ticket_states.id = tickets.ticket_state_id')
            ->where('ticket_states.state', 'Resolved')
            ->where('tickets.created_by', $current_user_id)
            ->countAllResults();
        }

        $all_office_section_division = $office_section_division->findAll();
        $all_ticket_categories = $ticket_category->findAll();
        $all_ticket_states = $ticket_state->findAll();
        
    
        // $all_critical_category_tickets_count = $ticket_category->where('ticket_category', 'Critical')->countAllResults();
        // $all_tickets_count = $ticket_category->countAllResults();
        // $all_pending_tickets_count = $ticket_state->where('state', 'Pending')->countAllResults();
        // $all_processing_tickets_count = $ticket_state->where('state', 'Processing')->countAllResults();
        // $all_resolved_tickets_count = $ticket_state->where('state', 'Resolved')->countAllResults();
        $data = [
            'low_category_tickets_count' => $all_low_category_tickets_count,
            'medium_category_tickets_count' => $all_medium_category_tickets_count,
            'high_category_tickets_count' => $all_high_category_tickets_count,
            'critical_category_tickets_count' => $all_critical_category_tickets_count,
            'tickets_count' => $all_tickets_count,
            'pending_tickets_count' => $all_pending_tickets_count,
            'processing_tickets_count' => $all_processing_tickets_count,
            'resolved_tickets_count' => $all_resolved_tickets_count,
            'offices' => $all_office_section_division,
            'ticket_categories' => $all_ticket_categories,
            'ticket_states' => $all_ticket_states,
            'current_user_group' => $current_user_group,
        ];
        return view('dashboard/index',$data);
    }
}
