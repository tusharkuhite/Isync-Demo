<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\UserModel;
use App\Models\admin\CompanyModel;
use App\Libraries\General;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {

            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {

                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $criteria["iRoleId"]        = Session::get('iRoleId');
                $criteria["iUserId"]        = Session::get('iUserId');
                $data['admin']              = UserModel::get_by_id($criteria);

                $vUniqueCode                = Session::get('vUniqueCode');
                if ($data['admin'] != null  && $data['admin']->vUniqueCode == $vUniqueCode) {
                    if (!empty($data['admin'])) {
                        $data['vUniqueCode']     = $vUniqueCode;

                        return view('admin.profile.index')->with($data);
                    } else {
                        return redirect()->route('admin.admin.listing');
                    }
                } else {

                    return redirect()->route('admin.dashboard')->withError('can not access without permission.');
                }
            } else {

                return redirect()->route('admin.dashboard')->withError('can not access without permission.');
            }
        } else {

            return redirect()->route('admin.dashboard');
        }
    }

    public function change_password($vUniqueCode)
    {

        if ($vUniqueCode != null) {

            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
                $criteria                   = array();
                $criteria["vUniqueCode"]    = Session::get('vUniqueCode');
                $criteria["iRoleId"]        = Session::get('iRoleId');
                $criteria["iUserId"]        = Session::get('iUserId');
                $data['admin']              = UserModel::get_by_id($criteria);
                $data['vUniqueCode']       = $vUniqueCode;

                return view('admin.profile.change_password')->with($data);
            } else {

                return redirect()->route('admin.dashboard')->withError('can not access without permission.');
            }
        } else {

            return redirect()->route('admin.dashboard');
        }
    }

    public function store(Request $request)
    {

        $vUniqueCode = $request->vUniqueCode;

        $data                 = array();
        $data['vFirstName']   = $request->vFirstName;
        $data['vLastName']    = $request->vLastName;
        $data['vEmail']       = strtolower($request->vEmail);
        $data['vPhone']       = $request->vPhone;
        $data['vImageAlt']    = $request->vImageAlt;
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

            Session::put('vEmail', $request->vEmail);
            $username = $request->vFirstName . ' ' . $request->vLastName;
            Session::put('username', $username);
            Session::put('vUniqueCode', $vUniqueCode);

            if ($request->hasFile('vImage')) {
                $image = $request->file('vImage');
                $basePath    = 'uploads/user';
                $mainPath    = $basePath . '/user_main';
                $smallPath   = $basePath . '/user_small';
                $data_image = General::upload_image($image, $smallPath, $mainPath);

                if ($data_image['type'] == 'IMAGE_COMPRESS_ISSUE') {

                    return redirect()->back()->with([
                        'success' => 'Your profile data updated successfully.',
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
                    $id = UserModel::UpdateData($where, $data);

                    Session::put('vWebpImage', $data['vWebpImage']);
                    Session::put('vImage', $data['vImage']);

                    return redirect()->back()->with([
                        'success' => 'Your profile data updated successfully.'
                    ]);
                } elseif ($data_image['type'] == 'IMAGE_UPLOADED_ISSUE') {
                    return redirect()->back()->with([
                        'success' => 'Your profile Data updated successfully.',
                        'error' => 'Image not uploaded, something went wrong!',
                    ]);
                } elseif ($data_image['type'] == 'IMAGE_UNSUPPORTED_ISSUE') {
                    return redirect()->back()->with([
                        'success' => 'Your profile updated successfully.',
                        'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
                    ]);
                }
            }
            return redirect()->back()->with([
                'success' => 'Your profile data updated successfully.',
            ]);
        }
    }
}
