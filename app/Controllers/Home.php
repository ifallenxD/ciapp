<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // generate return view to login page 

        return view('dashboard/index');
    }
}
