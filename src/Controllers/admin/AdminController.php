<?php
<<<<<<< HEAD
=======

>>>>>>> 594515e (testing)
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\admin\UserModel;
use App\Models\admin\RoleModel;
use App\Models\admin\PaginationModel;
use App\Models\admin\PermissionModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\StateModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Validator;
use Session;
use Intervention\Image\Facades\Image;
=======
use App\Models\admin\UserModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Illuminate\Support\Facades\Session;
>>>>>>> 594515e (testing)

class AdminController extends Controller
{
    public function index()
<<<<<<< HEAD
    {   
        $data        = General::check_module_permission();
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {  
            return view('admin.admin.listing')->with($data);
        }
        else
        {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
=======
    {
        $data        = General::check_module_permission();
        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.admin.listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }

    public function ajax_listing(Request $request)
    {

        $Pagination_Information     = General::get_pagination_count();
        $vAction        = $request->vAction;
        $eStatuschange  = $request->eStatuschange;
        $vUniqueCode    = $request->vUniqueCode;
        $eStatus        = $request->eStatus;
        $eDelete        = $request->eDelete;
<<<<<<< HEAD
        $vColumn        = "user.iUserId";
        $vOrder         = "DESC";
        $eStatus_search = $request->eStatus_search;
        $eDeleted       = $request->eDeleted;
        $vKeyword       = $request->keyword; 

        if($vKeyword != "")
        {
           $vKeyword  = $request->keyword;    
        } 
        else 
        {
           $vKeyword  = "";
        }

        if($vAction == "recover" && !empty($vUniqueCode))
        {
=======
        $vColumn        = "users.iUserId";
        $vOrder         = "DESC";
        $eStatus_search = $request->eStatus_search;
        $eDeleted       = $request->eDeleted;
        $vKeyword       = $request->keyword;

        if ($vKeyword != "") {
            $vKeyword  = $request->keyword;
        } else {
            $vKeyword  = "";
        }

        if ($vAction == "recover" && !empty($vUniqueCode)) {
>>>>>>> 594515e (testing)
            $where                  = array();
            $where["vUniqueCode"]   = $vUniqueCode;
            $data                   = array();
            $data['eDelete']        = "No";
<<<<<<< HEAD
            
            $ID = UserModel::UpdateData($where,$data);
        }

        if($vAction == "delete" && !empty($vUniqueCode))
        {
=======

            $ID = UserModel::UpdateData($where, $data);
        }

        if ($vAction == "delete" && !empty($vUniqueCode)) {
>>>>>>> 594515e (testing)

            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data = array();
            $data['eDelete'] = 'Yes';
<<<<<<< HEAD
            $ID = UserModel::UpdateData($where,$data);
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));
            
            if($eStatus == "delete")
            {
                foreach ($result as $key => $value) 
                {
=======
            $ID = UserModel::UpdateData($where, $data);
        }
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));

            if ($eStatus == "delete") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
<<<<<<< HEAD
                    $ID = UserModel::UpdateData($where,$data);
                   
                }
            }
            elseif($eStatus == "Recover")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = UserModel::UpdateData($where, $data);
                }
            } elseif ($eStatus == "Recover") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
<<<<<<< HEAD
                    $ID = UserModel::UpdateData($where,$data);
                }
            }
            elseif(!empty($eStatuschange))
            { 
=======
                    $ID = UserModel::UpdateData($where, $data);
                }
            } elseif (!empty($eStatuschange)) {
>>>>>>> 594515e (testing)
                $where                 = array();
                $where['vUniqueCode']  = $request->vUniqueCode;
                $data = array();
                $data['eStatus']       = $eStatuschange;
<<<<<<< HEAD
                $ID = UserModel::UpdateData($where,$data);
            }
            else
            {
                foreach ($result as $key => $value) 
                {
=======
                $ID = UserModel::UpdateData($where, $data);
            } else {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;
<<<<<<< HEAD
                    
                    $ID = UserModel::UpdateData($where,$data);  
=======

                    $ID = UserModel::UpdateData($where, $data);
>>>>>>> 594515e (testing)
                }
            }
        }

        $criteria                   = array();
        $criteria['vKeyword']       = $vKeyword;
<<<<<<< HEAD
        if($eStatus_search != null)
        { 
           $criteria['eStatus']     = $eStatus_search;
        }

        if($eDeleted != null)
        {
           $criteria['eDelete']     = $eDeleted;
=======
        if ($eStatus_search != null) {
            $criteria['eStatus']     = $eStatus_search;
        }

        if ($eDeleted != null) {
            $criteria['eDelete']     = $eDeleted;
>>>>>>> 594515e (testing)
        }
        $criteria["paging"]         = false;
        $criteria['column']         = $vColumn;
        $criteria['order']          = $vOrder;
        $criteria['vRole']          = "Admin";
        $AdminData                  = UserModel::total_user_data($criteria);
        $pages                      = 1;
<<<<<<< HEAD
        if($request->pages != "")
        {
=======
        if ($request->pages != "") {
>>>>>>> 594515e (testing)
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $AdminData;
<<<<<<< HEAD
        if(!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
        if(!empty($request->limit_page))
        {
            $selectedpagelimit = $request->limit_page;
        }
        else
        {
=======
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
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

        $data                   = array();
        $data['data']           = UserModel::get_all_data($criteria);
<<<<<<< HEAD
        
        if($paginator->total > $selectedpagelimit)
        {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        $data1        = General::check_module_permission();
        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {   $data['permission'] = $data1['permission'];
            $data['AdminData'] = $AdminData;
            
            return view('admin.admin.ajax_listing')->with($data); 
        }
        else
        {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }  
    }

    public function add()
    {   
        $data        = General::check_module_permission();
        
        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        {   
            return view('admin.admin.profile_add')->with($data);
        }
        else
        {
            return redirect()->route('admin.admin.listing')->withError('can not access without permission.');
        }     
=======

        if ($paginator->total > $selectedpagelimit) {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        $data1        = General::check_module_permission();
        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data['permission'] = $data1['permission'];
            $data['AdminData'] = $AdminData;

            return view('admin.admin.ajax_listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function add()
    {
        $data        = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
            return view('admin.admin.profile_add')->with($data);
        } else {
            return redirect()->route('admin.admin.listing')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }

    public function edit($vUniqueCode)
    {
<<<<<<< HEAD
        if(!empty($vUniqueCode))
        {
            
            $criteria                   = array();
            $criteria["vUniqueCode"]    = $vUniqueCode;
            $data['admin']             = UserModel::get_by_id($criteria);
            
            if(!empty($data['admin']))
            {   
                $data1        = General::check_module_permission();

                if($data1["permission"] != null && $data1["permission"]->eWrite == "Yes")
                { 
                    $data['permission'] = $data1['permission'];
                    return view('admin.admin.profile_add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.admin.listing')->withError('can not access without permission');
                }
            }
            else
            {
                return redirect()->route('admin.admin.listing');
            }
        }
        else
        {
=======
        if (!empty($vUniqueCode)) {

            $criteria                   = array();
            $criteria["vUniqueCode"]    = $vUniqueCode;
            $data['admin']             = UserModel::get_by_id($criteria);

            if (!empty($data['admin'])) {
                $data1        = General::check_module_permission();

                if ($data1["permission"] != null && $data1["permission"]->eWrite == "Yes") {
                    $data['permission'] = $data1['permission'];
                    return view('admin.admin.profile_add')->with($data);
                } else {
                    return redirect()->route('admin.admin.listing')->withError('can not access without permission');
                }
            } else {
                return redirect()->route('admin.admin.listing');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.admin.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
<<<<<<< HEAD
        
        $criteria             = array();
        $criteria["vRole"]    = "Admin";
        $iRoleId              = General::get_role_id($criteria);
        
=======

        $criteria             = array();
        $criteria["vRole"]    = "Admin";
        $iRoleId              = General::get_role_id($criteria);

>>>>>>> 594515e (testing)
        $data                 = array();
        $data['vFirstName']   = $request->vFirstName;
        $data['vLastName']    = $request->vLastName;
        $data['vEmail']       = strtolower($request->vEmail);
        $data['vPhone']       = $request->vPhone;
        $data['vImageAlt']    = $request->vImageAlt;

<<<<<<< HEAD
        if($iRoleId != null)
        {
=======
        if ($iRoleId != null) {
>>>>>>> 594515e (testing)
            $data['iRoleId']      = $iRoleId;
        }
        $data['eStatus']      = $request->eStatus;

<<<<<<< HEAD
        if(!empty($vUniqueCode))
        {   
=======
        if (!empty($vUniqueCode)) {
>>>>>>> 594515e (testing)
            // remove old profile image from folder
            $criteria                 = array();
            $criteria['vUniqueCode']  = $vUniqueCode;
            $userData                 = UserModel::get_by_id($criteria);

            $data['dtUpdatedDate']    = date("Y-m-d H:i:s");
            $where                    = array();
            $where['vUniqueCode']     = $vUniqueCode;
            $AdminIds                 = UserModel::UpdateData($where, $data);
            $AdminEmail               = Session::get('vEmail');

            //-- update session data if login admin update his profile 
<<<<<<< HEAD
            if($AdminEmail == $request->vEmail)
            {
                Session::put('vEmail',$request->vEmail);
                $username = $request->vFirstName.' '.$request->vLastName;
                Session::put('username',$username);
                Session::put('vUniqueCode',$vUniqueCode);
            }

            if($request->hasFile('vImage')) 
            {
=======
            if ($AdminEmail == $request->vEmail) {
                Session::put('vEmail', $request->vEmail);
                $username = $request->vFirstName . ' ' . $request->vLastName;
                Session::put('username', $username);
                Session::put('vUniqueCode', $vUniqueCode);
            }

            if ($request->hasFile('vImage')) {
>>>>>>> 594515e (testing)

                $image = $request->file('vImage');
                $basePath    = 'uploads/user';
                $mainPath    = $basePath . '/user_main';
                $smallPath   = $basePath . '/user_small';
<<<<<<< HEAD
                $data_image = General::upload_image($image,$smallPath,$mainPath);

               if($data_image['type'] == 'IMAGE_COMPRESS_ISSUE'){
=======
                $data_image = General::upload_image($image, $smallPath, $mainPath);

                if ($data_image['type'] == 'IMAGE_COMPRESS_ISSUE') {
>>>>>>> 594515e (testing)

                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account data updated successfully.',
                        'error' => 'This Image has issue to compress, Please upload another image.',
                    ]);
<<<<<<< HEAD

                }elseif($data_image['type'] == 'SUCCESS'){
                    $where = array();
                    $where['vUniqueCode'] = $vUniqueCode;
                    $row = UserModel::get_by_id($where);
                    if(!empty($row->vImage)){
                        $vImage = $mainPath.'/'.$row->vImage;
                        General::amazon_s3_delete($vImage);
                    }
                    if(!empty($row->vWebpImage)){
                        $vWebImage = $smallPath.'/'.$row->vWebpImage;
                        General::amazon_s3_delete($vWebImage);
                    }

                    
                    $data               = array();
                    $data['vImage']     = $data_image['data']['vImage'];
                    $data['vWebpImage'] = $data_image['data']['vWebpImage'];
                    $id = UserModel::UpdateData($where, $data);
                    
                    Session::put('vWebpImage',$data['vWebpImage']);
                    Session::put('vImage',$data['vImage']);
=======
                } elseif ($data_image['type'] == 'SUCCESS') {
                    $where = array();
                    $where['vUniqueCode'] = $vUniqueCode;
                    $row = UserModel::get_by_id($where);
                    if (!empty($row->vImage)) {
                        $vImage = $mainPath . '/' . $row->vImage;
                        if (file_exists($vImage)) {
                            unlink($vImage);
                        }
                    }
                    if (!empty($row->vWebpImage)) {
                        $vWebImage = $smallPath . '/' . $row->vWebpImage;
                        if (file_exists($vWebImage)) {
                            unlink($vWebImage);
                        }
                    }


                    $data               = array();
                    $data['vImage']     = $data_image['data']['vImage'];
                    $data['vWebpImage'] = $data_image['data']['vWebpImage'];
                    UserModel::UpdateData($where, $data);

                    Session::put('vWebpImage', $data['vWebpImage']);
                    Session::put('vImage', $data['vImage']);
>>>>>>> 594515e (testing)

                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account data updated successfully.'
                    ]);
<<<<<<< HEAD
                }elseif($data_image['type'] == 'IMAGE_UPLOADED_ISSUE'){
                    return redirect()->route('admin.admin.listing')->with([
                                'success' => 'Admin account Data updated successfully.',
                                'error' => 'Image not uploaded, something went wrong!',
                            ]);
                }elseif($data_image['type'] == 'IMAGE_UNSUPPORTED_ISSUE'){
                    return redirect()->route('admin.admin.listing')->with([
                                'success' => 'Admin account updated successfully.',
                                'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
                            ]);
                }
                
            }

            $roles  =\App\Libraries\General::get_role();
            
            if($roles->vRole == "Admin")
            {
                return redirect()->route('admin.admin.listing')->withSuccess('Admin Account Data updated successfully.');
            }
            else
            {   
                return redirect()->route('admin.dashboard')->withSuccess($roles->vRole . ' Account Data updated successfully.');
            } 
        }
        else
        {                                 
            $data['dtAddedDate']     = date("Y-m-d h:i:s");
            $data['vPassword']       = md5($request->vPassword);
            $ID = UserModel::AddData($data);
           
            if($ID != null)
            {
                $where = array();
                $where["iUserId"] = $ID;
                $data = array();
                $data['vUniqueCode']   = md5(uniqid(rand(),true)).md5(time()).md5($ID);
                UserModel::UpdateData($where, $data);

                if($request->hasFile('vImage')) {
=======
                } elseif ($data_image['type'] == 'IMAGE_UPLOADED_ISSUE') {
                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account Data updated successfully.',
                        'error' => 'Image not uploaded, something went wrong!',
                    ]);
                } elseif ($data_image['type'] == 'IMAGE_UNSUPPORTED_ISSUE') {
                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account updated successfully.',
                        'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
                    ]);
                }
            }

            $roles  = \App\Libraries\General::get_role();

            if ($roles->vRole == "Admin") {
                return redirect()->route('admin.admin.listing')->withSuccess('Admin Account Data updated successfully.');
            } else {
                return redirect()->route('admin.dashboard')->withSuccess($roles->vRole . ' Account Data updated successfully.');
            }
        } else {
            $data['dtAddedDate']     = date("Y-m-d h:i:s");
            $data['vPassword']       = md5($request->vPassword);
            $ID = UserModel::AddData($data);

            if ($ID != null) {
                $where = array();
                $where["iUserId"] = $ID;
                $data = array();
                $data['vUniqueCode']   = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
                UserModel::UpdateData($where, $data);

                if ($request->hasFile('vImage')) {
>>>>>>> 594515e (testing)
                    $uploadedImage = $request->file('vImage');
                    $basePath  = 'uploads/user';
                    $mainPath  = $basePath . '/user_main';
                    $smallPath = $basePath . '/user_small';
<<<<<<< HEAD
                    $data_image = General::upload_image($uploadedImage,$smallPath,$mainPath);

                    if($data_image['type'] == 'IMAGE_COMPRESS_ISSUE'){
=======
                    $data_image = General::upload_image($uploadedImage, $smallPath, $mainPath);

                    if ($data_image['type'] == 'IMAGE_COMPRESS_ISSUE') {
>>>>>>> 594515e (testing)
                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin Account data created successfully.',
                            'error' => 'This Image has issue to compress, Please upload another image.',
                        ]);
<<<<<<< HEAD
                    }elseif($data_image['type'] == 'SUCCESS'){
=======
                    } elseif ($data_image['type'] == 'SUCCESS') {
>>>>>>> 594515e (testing)
                        $where = array();
                        $where['vUniqueCode'] = $data['vUniqueCode'];
                        $data               = array();
                        $data['vImage']     = $data_image['data']['vImage'];
                        $data['vWebpImage'] = $data_image['data']['vWebpImage'];

                        $id = UserModel::UpdateData($where, $data);

                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin Account Data created successfully.'
                        ]);
<<<<<<< HEAD
                    }elseif($data_image['type'] == 'IMAGE_UPLOADED_ISSUE'){
                        return redirect()->route('admin.admin.listing')->with([
                                    'success' => 'Admin account data created successfully.',
                                    'error' => 'Image not uploaded, something went wrong!',
                                ]);
                    }elseif($data_image['type'] == 'IMAGE_UNSUPPORTED_ISSUE'){
                        return redirect()->route('admin.admin.listing')->with([
                                    'success' => 'Admin account created successfully.',
                                    'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
                                ]);
                    }

=======
                    } elseif ($data_image['type'] == 'IMAGE_UPLOADED_ISSUE') {
                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin account data created successfully.',
                            'error' => 'Image not uploaded, something went wrong!',
                        ]);
                    } elseif ($data_image['type'] == 'IMAGE_UNSUPPORTED_ISSUE') {
                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin account created successfully.',
                            'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
                        ]);
                    }
>>>>>>> 594515e (testing)
                }
            }
            return redirect()->route('admin.admin.listing')->withSuccess('Admin account created successfully.');
        }
    }
<<<<<<< HEAD
    

    public function change_password($vUniqueCode)
    {
        if(!empty($vUniqueCode))
        {
            $criteria                   = array();
            $criteria["vUniqueCode"]    = $vUniqueCode;
            $data['admin']              = UserModel::get_by_id($criteria);
            
            if(isset($data['admin']) && $data['admin']!='')
            {   
=======


    public function change_password($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {
            $criteria                   = array();
            $criteria["vUniqueCode"]    = $vUniqueCode;
            $data['admin']              = UserModel::get_by_id($criteria);

            if (isset($data['admin']) && $data['admin'] != '') {
>>>>>>> 594515e (testing)
                $data['vUniqueCode'] = $vUniqueCode;

                $data1        = General::check_module_permission();

<<<<<<< HEAD
                if( $data1["permission"] != null && $data1["permission"]->eWrite == "Yes")
                {
                    $data['permission'] = $data1['permission'];
                    return view('admin.admin.change_password')->with($data);
                }
                else
                {
                    return redirect()->route('admin.admin.listing')->withError('can not access without permission');
                }
            }
            else
            {
                return redirect()->route('admin.admin.listing');
            }
        }
        else
        {
=======
                if ($data1["permission"] != null && $data1["permission"]->eWrite == "Yes") {
                    $data['permission'] = $data1['permission'];
                    return view('admin.admin.change_password')->with($data);
                } else {
                    return redirect()->route('admin.admin.listing')->withError('can not access without permission');
                }
            } else {
                return redirect()->route('admin.admin.listing');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.admin.listing');
        }
    }

    public function change_password_action(Request $request)
    {
        $vUniqueCode                  = $request->vUniqueCode;

<<<<<<< HEAD
        if(!empty($vUniqueCode))
        {
=======
        if (!empty($vUniqueCode)) {
>>>>>>> 594515e (testing)
            $data                         = array();
            $data['vPassword']            = md5($request->vPassword);
            $data['dtUpdatedDate']        = date("Y-m-d h:i:s");
            $where                        = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $ID = UserModel::UpdateData($where, $data);

            $data        = General::check_module_permission();

<<<<<<< HEAD
            if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
            {
                return redirect()->route('admin.admin.listing')->withSuccess('Admin Password updated successfully.');
            }
            else
            {
                return redirect()->route('admin.admin.listing')->withError('can not access without permission');
            }
        }
        else
        {
=======
            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
                return redirect()->route('admin.admin.listing')->withSuccess('Admin Password updated successfully.');
            } else {
                return redirect()->route('admin.admin.listing')->withError('can not access without permission');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.admin.listing');
        }
    }

    //----- for check unique email ----->

    public function check_unique_email(Request $request)
<<<<<<< HEAD
        {  
           
            if(isset($request->vEmail) && isset($request->vUniqueCode)) {
               
               
                $criteria['vEmail'] = $request->vEmail; 
                $criteria['vUniqueCode'] = $request->vUniqueCode; 
                $data = UserModel::check_unique_email($criteria);
                
                if(!empty($data)) {
                    return 'false';
                } else {
                    $criteria1['vEmail'] = $request->vEmail; 
                $data1 = UserModel::check_unique_email($criteria1);
                if(!isset($data1)){
                    return 'false';
                }
                    return 'true';
                }
            } elseif($request->vUniqueCode == null) {
                if($request->vEmail != null) {
                    $criteria['vEmail'] = $request->vEmail;
                    $data = UserModel::check_unique_email($criteria);
                    if(!empty($data)) {
                        return 'true';
                    } else {
                        return 'false';
                    }
=======
    {

        if (isset($request->vEmail) && isset($request->vUniqueCode)) {


            $criteria['vEmail'] = $request->vEmail;
            $criteria['vUniqueCode'] = $request->vUniqueCode;
            $data = UserModel::check_unique_email($criteria);

            if (!empty($data)) {
                return 'false';
            } else {
                $criteria1['vEmail'] = $request->vEmail;
                $data1 = UserModel::check_unique_email($criteria1);
                if (!isset($data1)) {
                    return 'false';
                }
                return 'true';
            }
        } elseif ($request->vUniqueCode == null) {
            if ($request->vEmail != null) {
                $criteria['vEmail'] = $request->vEmail;
                $data = UserModel::check_unique_email($criteria);
                if (!empty($data)) {
                    return 'true';
>>>>>>> 594515e (testing)
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
<<<<<<< HEAD
        }
}
=======
        } else {
            return 'false';
        }
    }
}
>>>>>>> 594515e (testing)
