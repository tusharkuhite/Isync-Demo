<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\admin\SystemEmailModel;
use App\Models\admin\PaginationModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Session;
use Validator;
use Route;
use Intervention\Image\Facades\Image;
=======
use App\Models\admin\SystemEmailModel;
use App\Libraries\Paginator;
use App\Libraries\General;
>>>>>>> 594515e (testing)

class SystemEmailController extends Controller
{
    public function index()
<<<<<<< HEAD
    {   
        $data  = General::check_module_permission();
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {  
            return view('admin.system_email.listing')->with($data);

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
=======
    {
        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.system_email.listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }

    public function ajax_listing(Request $request)
    {
<<<<<<< HEAD
       
        $Pagination_Information     = General::get_pagination_count();
        
=======

        $Pagination_Information     = General::get_pagination_count();

>>>>>>> 594515e (testing)
        $vAction         = $request->vAction;

        $vUniqueCode     = $request->vUniqueCode;
        $vEmailTitle     = $request->vEmailTitle;
        $vEmailCode      = $request->vEmailCode;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iSystemEmailId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eDeleted        = $request->eDeleted;

<<<<<<< HEAD
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));          
                foreach ($result as $key => $value) 
                {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;
                    
                    $ID = SystemEmailModel::UpdateData($where,$data);  
                } 
=======
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));
            foreach ($result as $key => $value) {
                $where = array();
                $where["vUniqueCode"] = $value;

                $data = array();
                $data['eStatus'] = $eStatus;

                $ID = SystemEmailModel::UpdateData($where, $data);
            }
>>>>>>> 594515e (testing)
        }

        $criteria                    = array();
        $criteria['vEmailTitle']     = $vEmailTitle;
        $criteria['vEmailCode']      = $vEmailCode;
        $criteria['eStatus']         = $eStatus;
        $criteria["paging"]          = false;
<<<<<<< HEAD
        if($eStatus_search != null)
        {
           $criteria['eStatus']      = $eStatus_search;
        }
        if($eDeleted != null)
        {
           $criteria['eDelete']      = $eDeleted;
=======
        if ($eStatus_search != null) {
            $criteria['eStatus']      = $eStatus_search;
        }
        if ($eDeleted != null) {
            $criteria['eDelete']      = $eDeleted;
>>>>>>> 594515e (testing)
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $SystemEmailData             = SystemEmailModel::total_system_email_data($criteria);
        $pages                       = 1;
<<<<<<< HEAD
        if($request->pages != "")
        {
=======
        if ($request->pages != "") {
>>>>>>> 594515e (testing)
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $SystemEmailData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
<<<<<<< HEAD
        if(!empty($request->limit_page))
        {
            $selectedpagelimit = $request->limit_page;
        }
        else  
        {
=======
        if (!empty($request->limit_page)) {
            $selectedpagelimit = $request->limit_page;
        } else {
>>>>>>> 594515e (testing)
            $selectedpagelimit = $paginator->itemsPerPage;
        }
        $start = ($paginator->currentPage - 1) * $selectedpagelimit;
        $limit = $selectedpagelimit;
        $paginator->is_ajax = true;
        $paging = true;
        $criteria["start"]      = $start;
        $criteria["limit"]      = $limit;
        $criteria["paging"]     = $paging;
<<<<<<< HEAD
        
        $data                   = array();
        $data['data']           = SystemEmailModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
=======

        $data                   = array();
        $data['data']           = SystemEmailModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
>>>>>>> 594515e (testing)
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $data1  = General::check_module_permission();
<<<<<<< HEAD
        
        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {   
            $data["permission"] = $data1["permission"];
            $data['SystemEmailData']  = $SystemEmailData;
            return view('admin.system_email.ajax_listing')->with($data);  

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
=======

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['SystemEmailData']  = $SystemEmailData;
            return view('admin.system_email.ajax_listing')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }
    public function add()
    {
        $data  = General::check_module_permission();

<<<<<<< HEAD
        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        { 
            return view('admin.system_email.add')->with($data);
        }else{

            return redirect()->route('make.listing')->withError('can not access without permission.');
        }  
    }
    public function edit($vUniqueCode)
    {  
        if(!empty($vUniqueCode))
        {  
            $data  = General::check_module_permission();

            if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
            {   
=======
        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
            return view('admin.system_email.add')->with($data);
        } else {

            return redirect()->route('make.listing')->withError('can not access without permission.');
        }
    }
    public function edit($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {
            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
>>>>>>> 594515e (testing)
                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['systemEmail']        = SystemEmailModel::get_by_id($criteria);

                return view('admin.system_email.add')->with($data);
<<<<<<< HEAD
                
            }else{

                return redirect()->route('system_email.listing')->withError('can not access without permission.');
            }  
        }
        else
        {
=======
            } else {

                return redirect()->route('system_email.listing')->withError('can not access without permission.');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.systemEmail.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vEmailSubject']      = $request->vEmailSubject;
        $data['tEmailMessage']      = $request->tEmailMessage;
        $data['vEmailCode']         = $request->vEmailCode;
        $data['vFromName']          = $request->vFromName;
        $data['vFromEmail']         = $request->vFromEmail;
<<<<<<< HEAD
        $data['eStatus']            = $request->eStatus;        
        if(!empty($vUniqueCode)){
=======
        $data['eStatus']            = $request->eStatus;
        if (!empty($vUniqueCode)) {
>>>>>>> 594515e (testing)
            $where                  = array();
            $where['vUniqueCode']   = $vUniqueCode;
            $data['dtUpdatedDate']  = date("Y-m-d h:i:s");
            $ID = SystemEmailModel::UpdateData($where, $data);

            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email updated successfully.');
<<<<<<< HEAD
        }
        else{
=======
        } else {
>>>>>>> 594515e (testing)

            $data['dtAddedDate']     = date("Y-m-d h:i:s");
            $ID = SystemEmailModel::AddData($data);

            $where = array();
            $where["iSystemEmailId"]  = $ID;
            $data  = array();
<<<<<<< HEAD
            $data['vUniqueCode']      = md5(uniqid(rand(),true)).md5(time()).md5($ID);
=======
            $data['vUniqueCode']      = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
>>>>>>> 594515e (testing)
            SystemEmailModel::UpdateData($where, $data);
            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email created successfully.');
        }
    }
<<<<<<< HEAD
    
}

=======
}
>>>>>>> 594515e (testing)
