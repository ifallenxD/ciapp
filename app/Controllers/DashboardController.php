<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $author = new \App\Models\Author();
        $ticket = new \App\Models\Ticket();
        $ticket_category = new \App\Models\TicketCategory();
        $ticket_state = new \App\Models\TicketState();
        
        $totalauthors = $author->select('id')->countAllResults();
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
        $all_tickets_count = $ticket->countAllResults();
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

        // $all_critical_category_tickets_count = $ticket_category->where('ticket_category', 'Critical')->countAllResults();
        // $all_tickets_count = $ticket_category->countAllResults();
        // $all_pending_tickets_count = $ticket_state->where('state', 'Pending')->countAllResults();
        // $all_processing_tickets_count = $ticket_state->where('state', 'Processing')->countAllResults();
        // $all_resolved_tickets_count = $ticket_state->where('state', 'Resolved')->countAllResults();
        $data = [
            'totalauthors' => $totalauthors,
            'low_category_tickets_count' => $all_low_category_tickets_count,
            'medium_category_tickets_count' => $all_medium_category_tickets_count,
            'high_category_tickets_count' => $all_high_category_tickets_count,
            'critical_category_tickets_count' => $all_critical_category_tickets_count,
            'tickets_count' => $all_tickets_count,
            'pending_tickets_count' => $all_pending_tickets_count,
            'processing_tickets_count' => $all_processing_tickets_count,
            'resolved_tickets_count' => $all_resolved_tickets_count,
        ];
        return view('dashboard/index',$data);
    }
}
