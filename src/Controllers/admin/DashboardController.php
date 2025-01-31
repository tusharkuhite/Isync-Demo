<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Libraries\General;




class DashboardController extends Controller
{   
  public function index()
  {    
    $data = General::check_module_permission();

    return view('admin.dashboard.dashboard')->with($data);
  }
}




