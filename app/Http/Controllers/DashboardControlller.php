<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardControlller extends Controller
{
    public function index(){
        return view('pages.admin.index');
    }
}
