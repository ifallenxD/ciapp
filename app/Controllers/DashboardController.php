<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $author = new \App\Models\Author();
        $totalauthors = $author->select('id')->countAllResults();

        $data = [
            'totalauthors' => $totalauthors
        ];
        return view('dashboard/index',$data);
    }
}
