<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\UserModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $data        = General::check_module_permission();
        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.admin.listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function ajax_listing(Request $request)
    {

        $Pagination_Information     = General::get_pagination_count();
        $vAction        = $request->vAction;
        $eStatuschange  = $request->eStatuschange;
        $vUniqueCode    = $request->vUniqueCode;
        $eStatus        = $request->eStatus;
        $eDelete        = $request->eDelete;
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
            $where                  = array();
            $where["vUniqueCode"]   = $vUniqueCode;
            $data                   = array();
            $data['eDelete']        = "No";

            $ID = UserModel::UpdateData($where, $data);
        }

        if ($vAction == "delete" && !empty($vUniqueCode)) {

            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data = array();
            $data['eDelete'] = 'Yes';
            $ID = UserModel::UpdateData($where, $data);
        }
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));

            if ($eStatus == "delete") {
                foreach ($result as $key => $value) {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
                    $ID = UserModel::UpdateData($where, $data);
                }
            } elseif ($eStatus == "Recover") {
                foreach ($result as $key => $value) {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
                    $ID = UserModel::UpdateData($where, $data);
                }
            } elseif (!empty($eStatuschange)) {
                $where                 = array();
                $where['vUniqueCode']  = $request->vUniqueCode;
                $data = array();
                $data['eStatus']       = $eStatuschange;
                $ID = UserModel::UpdateData($where, $data);
            } else {
                foreach ($result as $key => $value) {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;

                    $ID = UserModel::UpdateData($where, $data);
                }
            }
        }

        $criteria                   = array();
        $criteria['vKeyword']       = $vKeyword;
        if ($eStatus_search != null) {
            $criteria['eStatus']     = $eStatus_search;
        }

        if ($eDeleted != null) {
            $criteria['eDelete']     = $eDeleted;
        }
        $criteria["paging"]         = false;
        $criteria['column']         = $vColumn;
        $criteria['order']          = $vOrder;
        $criteria['vRole']          = "Admin";
        $AdminData                  = UserModel::total_user_data($criteria);
        $pages                      = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $AdminData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
        if (!empty($request->limit_page)) {
            $selectedpagelimit = $request->limit_page;
        } else {
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
    }

    public function edit($vUniqueCode)
    {
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
            return redirect()->route('admin.admin.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;

        $criteria             = array();
        $criteria["vRole"]    = "Admin";
        $iRoleId              = General::get_role_id($criteria);

        $data                 = array();
        $data['vFirstName']   = $request->vFirstName;
        $data['vLastName']    = $request->vLastName;
        $data['vEmail']       = strtolower($request->vEmail);
        $data['vPhone']       = $request->vPhone;
        $data['vImageAlt']    = $request->vImageAlt;

        if ($iRoleId != null) {
            $data['iRoleId']      = $iRoleId;
        }
        $data['eStatus']      = $request->eStatus;

        if (!empty($vUniqueCode)) {
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
            if ($AdminEmail == $request->vEmail) {
                Session::put('vEmail', $request->vEmail);
                $username = $request->vFirstName . ' ' . $request->vLastName;
                Session::put('username', $username);
                Session::put('vUniqueCode', $vUniqueCode);
            }

            if ($request->hasFile('vImage')) {

                $image = $request->file('vImage');
                $basePath    = 'uploads/user';
                $mainPath    = $basePath . '/user_main';
                $smallPath   = $basePath . '/user_small';
                $data_image = General::upload_image($image, $smallPath, $mainPath);

                if ($data_image['type'] == 'IMAGE_COMPRESS_ISSUE') {

                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account data updated successfully.',
                        'error' => 'This Image has issue to compress, Please upload another image.',
                    ]);
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

                    return redirect()->route('admin.admin.listing')->with([
                        'success' => 'Admin account data updated successfully.'
                    ]);
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
                    $uploadedImage = $request->file('vImage');
                    $basePath  = 'uploads/user';
                    $mainPath  = $basePath . '/user_main';
                    $smallPath = $basePath . '/user_small';
                    $data_image = General::upload_image($uploadedImage, $smallPath, $mainPath);

                    if ($data_image['type'] == 'IMAGE_COMPRESS_ISSUE') {
                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin Account data created successfully.',
                            'error' => 'This Image has issue to compress, Please upload another image.',
                        ]);
                    } elseif ($data_image['type'] == 'SUCCESS') {
                        $where = array();
                        $where['vUniqueCode'] = $data['vUniqueCode'];
                        $data               = array();
                        $data['vImage']     = $data_image['data']['vImage'];
                        $data['vWebpImage'] = $data_image['data']['vWebpImage'];

                        $id = UserModel::UpdateData($where, $data);

                        return redirect()->route('admin.admin.listing')->with([
                            'success' => 'Admin Account Data created successfully.'
                        ]);
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
                }
            }
            return redirect()->route('admin.admin.listing')->withSuccess('Admin account created successfully.');
        }
    }


    public function change_password($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {
            $criteria                   = array();
            $criteria["vUniqueCode"]    = $vUniqueCode;
            $data['admin']              = UserModel::get_by_id($criteria);

            if (isset($data['admin']) && $data['admin'] != '') {
                $data['vUniqueCode'] = $vUniqueCode;

                $data1        = General::check_module_permission();

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
            return redirect()->route('admin.admin.listing');
        }
    }

    public function change_password_action(Request $request)
    {
        $vUniqueCode                  = $request->vUniqueCode;

        if (!empty($vUniqueCode)) {
            $data                         = array();
            $data['vPassword']            = md5($request->vPassword);
            $data['dtUpdatedDate']        = date("Y-m-d h:i:s");
            $where                        = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $ID = UserModel::UpdateData($where, $data);

            $data        = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
                return redirect()->route('admin.admin.listing')->withSuccess('Admin Password updated successfully.');
            } else {
                return redirect()->route('admin.admin.listing')->withError('can not access without permission');
            }
        } else {
            return redirect()->route('admin.admin.listing');
        }
    }

    //----- for check unique email ----->

    public function check_unique_email(Request $request)
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
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }
}
