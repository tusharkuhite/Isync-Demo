<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\SettingModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\General;
use Session;

class SettingController extends Controller
{
    public function index()
<<<<<<< HEAD
    {   

        $data  = General::check_module_permission();
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {
            return view('admin.setting.listing');

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
        
=======
    {

        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.setting.listing');
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }

    public function store(Request $request)
    {
        $eConfigType = $request->eConfigType;

        $criteria = array();
        $criteria['eStatus']     = 'Active';
        $criteria['eConfigType'] = $eConfigType;

        $settings = SettingModel::get_all_settings($criteria);

        foreach ($settings as $key => $value) {
            $settings = array();

            if ($value->vName == 'COMPANY_FAVICON') {
                $image = 'favicon.png';
                $setting = SettingModel::get_by_id($value->iSettingId);

                if ($request->hasFile($value->vName)) {
                    $request->validate([
                        'COMPANY_FAVICON' => 'required|mimes:png,jpg,jpeg,svg|max:2048'
                    ]);

                    $imageName = $image;
<<<<<<< HEAD
                    $path = 'uploads/logo';
                    $request->file($value->vName)->move($path, $imageName);
                    $imagePath = $path.'/'.$imageName;
        
                    $image_type    = $request->file($value->vName)->getClientMimeType();
                    General::amazon_s3_upload($imagePath,$image_type);
                   
=======
                    $path = public_path('uploads/logo');
                    $request->file($value->vName)->move($path, $imageName);
>>>>>>> 594515e (testing)

                    $path2 = public_path('admin/assets/img/favicon');
                    $existingImagePath = $path2.'/'.$image;

<<<<<<< HEAD
                    General::amazon_s3_delete($existingImagePath);

                    copy($path.'/'.$image, $path2.'/'.$image);
                    chmod($path2.'/'.$image, 0644);
                    
                    $settings['vValue'] = $image;
                    $where = ["vName" => $value->vName];
                    SettingModel::setting_update($where, $settings);
                    unlink($imagePath);

=======
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }

                    copy($path.'/'.$image, $path2.'/'.$image);

                    chmod($path2.'/'.$image, 0644);

                    $settings['vValue'] = $image;
                    $where = ["vName" => $value->vName];
                    $criteria                 = array();
                    $criteria['iSettingId']  = $value->iSettingId;
                    $DataBeforeUpdate          = SettingModel::get_by_id($criteria);

                    SettingModel::setting_update($where, $settings);
>>>>>>> 594515e (testing)
                }
            }
            else if ($value->vName == 'COMPANY_LOGO') {
                $image = 'logo.png';
                $setting = SettingModel::get_by_id($value->iSettingId);

                if ($request->hasFile($value->vName)) {
                    $request->validate([
                        'COMPANY_LOGO' => 'required|mimes:png,jpg,jpeg|max:2048'
                    ]);

                    $imageName = 'logo_' . time() . '.' . $request->file('COMPANY_LOGO')->getClientOriginalExtension();
<<<<<<< HEAD
                    $path = 'uploads/logo';
                    $request->file('COMPANY_LOGO')->move($path, $imageName);
                    $imagePath = $path.'/'.$imageName;
                    $image_type    = $request->file('COMPANY_LOGO')->getClientMimeType();
                    General::amazon_s3_upload($imagePath,$image_type);
                    
                    if(!empty($setting->vValue)){
                        $existingImagePath = $path.'/'.$setting->vValue;
                        if(General::amazonS3FileExist($existingImagePath)){
                            General::amazon_s3_delete($existingImagePath);
                        }
                    }

                    unlink($imagePath);
                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
=======
                    $path = public_path('uploads/logo');

                    $request->file('COMPANY_LOGO')->move($path, $imageName);

                    $path2 = public_path('admin/assets/img/logo');
                    $existingImagePath = $path2 . '/' . $image;

                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }

                    copy($path . '/' . $imageName, $path2 . '/' . $imageName);

                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
                    $criteria                 = array();
                    $criteria['iSettingId']  = $value->iSettingId;
                    $DataBeforeUpdate          = SettingModel::get_by_id($criteria);

>>>>>>> 594515e (testing)
                    SettingModel::setting_update($where, $settings);
                }
            }
            else if($value->vName == 'COMPANY_FOOTER_LOGO'){
                $image = 'footer_logo.png';
                $setting = SettingModel::get_by_id($value->iSettingId);

                if($request->hasFile($value->vName) == 'true'){
                    if ($request->hasFile($value->vName)) {
                        $request->validate([
                            'COMPANY_FOOTER_LOGO' => 'required|mimes:png,jpg,jpeg|max:2048'
                        ]);
                        $imageName      = $image;
<<<<<<< HEAD
                        $path           = 'uploads/logo';
                        $request[$value->vName]->move($path, $imageName);

                        $imagePath = $path.'/'.$imageName;
                        $image_type    = $request[$value->vName]->getClientMimeType();
                        General::amazon_s3_upload($imagePath,$image_type);
                        
                        
                        unlink($imagePath);
                        
=======
                        $path           = public_path('uploads/logo');
                        $request[$value->vName]->move($path, $imageName);
>>>>>>> 594515e (testing)
                    }
                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
<<<<<<< HEAD
=======
                    $criteria                 = array();
                    $criteria['iSettingId']  = $value->iSettingId;
                    $DataBeforeUpdate          = SettingModel::get_by_id($criteria);

>>>>>>> 594515e (testing)
                    SettingModel::setting_update($where, $settings);
                }
            }
            else if($value->vName == 'COMPANY_BANNER_LOGO'){
                $image = 'banner_logo.png';
                $setting = SettingModel::get_by_id($value->iSettingId);

                if($request->hasFile($value->vName) == 'true'){
                    if ($request->hasFile($value->vName)) {
                        $request->validate([
                            'COMPANY_BANNER_LOGO' => 'required|mimes:png,jpg,jpeg|max:2048'
                        ]);
                        $imageName      = $image;
<<<<<<< HEAD
                        $path           = 'uploads/logo';
                        $request[$value->vName]->move($path, $imageName);

                        $imagePath = $path.'/'.$imageName;
                        $image_type    = $request[$value->vName]->getClientMimeType();
                        General::amazon_s3_upload($imagePath,$image_type);
                        unlink($imagePath);
=======
                        $path           = public_path('uploads/logo');
                        $request[$value->vName]->move($path, $imageName);
>>>>>>> 594515e (testing)
                    }
                    $settings['vValue'] = $imageName;

                    $where = array("vName" => $value->vName);
<<<<<<< HEAD
=======
                    $criteria                 = array();
                    $criteria['iSettingId']  = $value->iSettingId;
                    $DataBeforeUpdate          = SettingModel::get_by_id($criteria);

>>>>>>> 594515e (testing)
                    SettingModel::setting_update($where, $settings);
                }
            }else{
                $setting = SettingModel::get_by_id($value->iSettingId);
                $settings['vValue'] = $request[$value->vName];
               
                $where = array("vName" => $value->vName);
               
<<<<<<< HEAD
                SettingModel::setting_update($where, $settings);
            }   
        }
        return redirect()->back()->withSuccess("Data updated successfully");
=======
                $criteria                 = array();
                    $criteria['iSettingId']  = $value->iSettingId;
                    $DataBeforeUpdate          = SettingModel::get_by_id($criteria);

                    SettingModel::setting_update($where, $settings);
            }   
        }
        return redirect()->back()->withSuccess(__('message.TOASTR_MSG_DATA_UPDATED'));
>>>>>>> 594515e (testing)
    }

    public function edit($eConfigType)
    {

<<<<<<< HEAD
      $data  = General::check_module_permission();
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {
=======
        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
>>>>>>> 594515e (testing)
            $data['eConfigType'] = $eConfigType;

            $criteria = array();
            $criteria['eStatus']     = 'Active';
            $criteria['eConfigType'] = $eConfigType;

            $data['settings'] = SettingModel::get_all_settings($criteria);
<<<<<<< HEAD
            
            return view('admin.setting.add')->with($data);

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
       
=======

            return view('admin.setting.add')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }
}
