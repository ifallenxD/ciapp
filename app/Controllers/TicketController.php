<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TicketController extends BaseController
{
    public function index()
    {
        $office_section_division = new \App\Models\OfficeSectionDivision();
        $all_office_section_division = $office_section_division->findAll();

        $data = [
            'offices' => $all_office_section_division
        ];

        return view('tickets/index', $data);
    }

}
