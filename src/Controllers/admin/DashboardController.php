<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\General;




class DashboardController extends Controller
{   
  public function index()
  {    
    return view('admin.dashboard.dashboard');
  }
}




