<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\RoleModel;
use App\Models\admin\UserModel;
use App\Models\admin\InviteModel;
use App\Models\admin\CategoryModel;
use App\Models\admin\BlogModel;
use App\Models\admin\ServiceModel;
use App\Models\admin\CompetencyModel;
use App\Models\admin\CompanyModel;
use App\Models\admin\PermissionModel;
use App\Libraries\General;
use Illuminate\Support\Facades\Session;




class DashboardController extends Controller
{   
  public function index()
  {    

    $criteria                     = array();
    $criteria["iRoleId"]          = Session::get('iRoleId');
    $criteria["eStatus"]          = 'Active';
    $criteria["eDelete"]          = 'No';
    $roledata                     = RoleModel::get_by_id($criteria);
    $permission                   = PermissionModel::get_all_data($criteria);
  
    $data = array();
    $data = General::check_module_permission();
   
    if(isset($data['permission']) && $data['permission']->vRole == 'Company'){
      $criteria = array();
      $criteria['iUserId'] = Session::get('iUserId');
     
      $company_data = CompanyModel::get_by_id($criteria);
      $data['company_name'] = $company_data->vCompanyName;
      $data['web_image'] =  General::getAmazonS3Link().'uploads/user/user_small/' . $company_data->vWebpImage;
    }


    foreach($permission as $key => $val){

      if($val->vModule == 'Company'){
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        $criteria['vRole']            = "Company";
        $data['company']              = UserModel::total_user_data($criteria);
      }

      if($val->vModule == 'Category'){
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        $data['category']             = CategoryModel::total_category_data($criteria);
      }
      
      if($val->vModule == 'Blog'){
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        $data['blog']                 = BlogModel::total_blog_data($criteria);
      }
      if($val->vModule == 'Service'){
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        $data['service']              = ServiceModel::total_service_data($criteria);
      }
      if($val->vModule == 'Competency'){
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        if(isset($data['permission']) && $data['permission']->vRole == 'Company'){
          $criteria['iUserId']        = Session::get('iUserId');
        }else{
          $criteria['user_null']        = 'null';
        }
        $data['competency']           = CompetencyModel::total_competency_data($criteria);
      }
      if($val->vModule == 'Statement'){ 
        $criteria                     = array();
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        if(isset($data['permission']) && $data['permission']->vRole == 'Company'){
          $criteria['iUserId']        = Session::get('iUserId');
        }else{
          $criteria['User_Null']        = 'null';
        }
        $data['statement']            = StatementModel::total_statement_data($criteria);
      }

      if(isset($data['permission']) && $data['permission']->vRole == 'Company'){
        $criteria                   = array();
        $criteria['iUserId']        = Session::get('iUserId');
        $criteria['eStatus']        = 'Pending';
        $data['pending'] = InviteModel::total_invite_data($criteria);
        
        $criteria['eStatus']        = 'Complete';
        $data['completed'] = InviteModel::total_invite_data($criteria);
        
      }
  }
    return view('admin.dashboard.dashboard')->with($data);
  }
}




