<?php
namespace App\Libraries;

use App\Models\admin\RoleModel;
use App\Models\admin\SettingModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\PermissionModel;
use App\Models\admin\MenuModel;
use App\Models\admin\PaginationModel;
use App\Models\admin\MetaModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

 
class General
{
    static function replaceContent($vTitle){
      
        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);

        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);
        $rs_catname = str_replace(")","",$rs_catname);
        $rs_catname = str_replace("?","",$rs_catname);
        $rs_catname = str_replace("-","-",$rs_catname);
        $rs_catname = str_replace("#","",$rs_catname);
        $rs_catname = str_replace(",","",$rs_catname);
        $rs_catname = str_replace(";","",$rs_catname);
        $rs_catname = str_replace(":","",$rs_catname);
        $rs_catname = str_replace("'","",$rs_catname);
        $rs_catname = str_replace("\"","",$rs_catname);
        $rs_catname = str_replace("++","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+�","-",$rs_catname);
        $rs_catname = str_replace(" $ ","-",$rs_catname);
        $rs_catname = str_replace("$","-",$rs_catname);      
        $rs_catname = str_replace(" ","-",str_replace("&","and",$rs_catname));
        
        return $rs_catname;
    }
    
    static function  get_role_id($criteria = array())
    {     
        $myArray                = array();
        $myArray["vRole"]       = $criteria["vRole"];
        $myArray["eStatus"]     = "Active";
        $data                   = RoleModel::get_by_id($myArray);
        return $data->iRoleId;
    }

    public function send_email($criteria = array())
    { 
      
        $email_info = SettingModel::get_setting('Email');

        $mailConfig = [
            'transport' => 'smtp',
            'host' => $email_info['SMTP_HOST']['vValue'],
            'port' => $email_info['SMTP_PORT']['vValue'],
            'encryption' => $email_info['EMAIL_PROTOCOL']['vValue'],
            'username' => $email_info['SMTP_USERNAME']['vValue'],
            'password' => $email_info['SMTP_PASS']['vValue'],
            'timeout' => null ];

        config(['mail.mailers.smtp' => $mailConfig]);
       
        Mail::send(['html' => 'admin.email.email_template'], $criteria, function ($message) use ($criteria) {
            $message->to($criteria["to"],)
            ->subject($criteria["subject"]);
            $message->from($criteria["from"], "Johari360");

        });
    }

    static function dash_permission($criteria = array())
    {  
        $criteria                = array();
        $criteria['vController'] = "DashboardController";
        $criteria['eDelete']     = "No";
        $criteria['eStatus']     = "Active";
        $module                  = ModuleModel::get_by_id($criteria);

       
        if($module != null)
        {  
            $criteria                   = array();
            $criteria["iRoleId"]        = Session::get('iRoleId');
            $criteria["iModuleId"]      = $module->iModuleId;
            $criteria["iUserId"]        = Session::get('iUserId');
            $data['permission']         = PermissionModel::get_by_id_permission($criteria);
            return $data;
        }
        
    }  

    static function  menu_module($criteria = array())
    {     
        $criteria               = array();
        $criteria["eStatus"]    = "Active"; 
        $criteria["eDelete"]    = "No";
        $criteria["column"]     = "iOrder";
        $criteria["order"]      = "ASC";
        $criteria["iRoleId"]    = Session::get('iRoleId');
        $data['menuData']       = MenuModel::get_all_data($criteria);
        
        foreach($data['menuData'] as $menukey=>$menuDatas)
        {
            if($menuDatas->vMenu != "Profile")
            {
                if($menuDatas->iModuleId != null)
                {
                    $criteria               = array();
                    $criteria["eStatus"]    = "Active"; 
                    $criteria["eDelete"]    = "No"; 
                    $criteria["iRoleId"]    = Session::get('iRoleId');
                    $criteria["iMenuId"]    = $menuDatas->iMenuId;
                    
                    $allmoduleDatas         = ModuleModel::get_all_data($criteria);
                    if(count($allmoduleDatas) != null)
                    {
                        $controllers = [];
                        foreach ($allmoduleDatas as $key => $values) 
                        {
                            $controllers[] = strtolower(strstr($values->vController,'Controller', true));
                        }
                    
                        $menuDatas->controllers = $controllers;
                    }

                    $menuDatas->permissionData = [];
                    foreach($menuDatas->iModuleId as $moduleData)
                    {
                        
                        $criteria                      = array();
                        $criteria["iRoleId"]           = Session::get('iRoleId');
                        $criteria["iModuleId"]         = $moduleData->iModuleId;
                        $criteria["iUserId"]           = Session::get('iUserId');
                        $moduleData->permissionData    = PermissionModel::get_by_id_permission($criteria);
                        if($moduleData->permissionData != null)
                        {
                            if($moduleData->permissionData->eRead == "Yes")
                            {
                                $menuDatas->permissionData[] = $moduleData->permissionData->eRead;
                            }else{

                                $menuDatas->permissionData   = null;
                            }

                        }
                    } 
                } 
            }
        }
        return $data;
    }

    static function check_permission($criteria = array())
    {  
        $permission_criteria                  = array();
        $permission_criteria["iRoleId"]       = Session::get('iRoleId');
        $permission_criteria["iModuleId"]     = $criteria["iModuleId"];
        $userPermissionData                   = PermissionModel::get_by_id_permission($permission_criteria);      
        return $userPermissionData;
    }  

    static function get_role()
    {
        $criteria                   = array();
        $criteria["iRoleId"]        = Session::get('iRoleId'); 
        $criteria["eStatus"]        = "Active"; 
        $criteria["eDelete"]        = "No"; 
        $roles                      = RoleModel::get_by_id($criteria);
        return $roles;
    }

    public function date_format_convert($date)
    {
        $replace_date = str_replace('/', '-', $date);

        $your_date = $replace_date ? date("Y-m-d", strtotime($replace_date)): NULL;

        return $your_date;
    }


      static function get_config_type(){
        $config_type = SettingModel::groupBy('eConfigType')->pluck('eConfigType');
        return $config_type;
    }

    static function setting_info($eConfigType)
    {
        $setting_info = SettingModel::get_setting($eConfigType);
        return $setting_info;
    }
    static function config_key_info($eConfigType)
    {
        $config_info = SettingModel::get_setting($eConfigType);
        return $config_info;
    }

    static function company_info(){
        $company_info = SettingModel::where('eConfigType','Company')->get();
        return $company_info;
    }

    static function user_info()
    {
        $user = Auth::user();
        return $user;
    }

    static function compress_image($criteria)
    {    

        $image  = Image::make($criteria['imagePath']);
        
        if($image->filesize() <= 50000)
        {
            $compress = 100;
        }
        elseif($image->filesize() <= 500000 && $image->filesize() > 50000)
        {
            $compress = 80;
        }else
        {
            $compress = 75;
        }

        $originalWidth  = $image->width();
        $originalHeight = $image->height();

        $smallPath      = $criteria['smallPath'];
        $originalImageNameWithoutExtension = $criteria['ImageName'];

        $minFileSize = 1 * 1024 * 1024; // 1 MB

        if ($image->filesize() > $minFileSize) {
            $targetWidth = $originalWidth;
            $targetHeight = $originalHeight;

            $maxFileSize = 2 * 1024; // 2 KB (converted from MB to KB)

            while ($image->filesize() > $maxFileSize && $targetWidth > 0 && $targetHeight > 0) {
                $targetWidth -= round($originalWidth * 0.1);
                $targetHeight -= round($originalHeight * 0.1);

                if ($targetWidth > 0 && $targetHeight > 0) {
                    $image->resize($targetWidth, $targetHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    break;
                }
            }
        }

        $webpPath = $smallPath . '/' . $originalImageNameWithoutExtension . '.webp';
        $image->save($webpPath, $compress);

        $compressedImageSize = $image->filesize();
             
        return [
            'webpPath' => $webpPath,
            'fileSize' => $compressedImageSize
        ];
    }


    static function meta_info($criteria = '')
    {
        if(!empty($criteria)){
            $meta = MetaModel::get_by_id($criteria);
            return $meta;
        }
    }

    static function check_module_permission(){
        $criteria                = array();
        $criteria['vController'] = class_basename(Route::current()->controller);
        $criteria['eDelete']     = "No";
        $criteria['eStatus']     = "Active";
        $criteria["iRoleId"]     = Session::get('iRoleId');
        $module                  = ModuleModel::get_by_id($criteria);

        if($module != null)
        {
            $criteria               = array();
            $criteria["iModuleId"]  = $module->iModuleId;
            $data["permission"]  = array();
            $data["permission"] = General::check_permission($criteria);
        }
        else
        {
            $data["permission"]  = array();
            $data["permission"]  = null;
        }
        return $data;
    }

    static function folder_create_if_not_exist($mainPath ='',$smallPath = ''){
        
        if(!file_exists(public_path($mainPath))  && $mainPath != '') 
        {
            mkdir(public_path($mainPath), 0755, true);
        }

        if(!file_exists(public_path($smallPath)) && $smallPath != '') 
        {
            mkdir(public_path($smallPath), 0755, true);
        }
    }

    static function folder_file_remove($small_img_path = '',$main_img_path = ''){
        if(file_exists($small_img_path) && $small_img_path != '') 
        {
            @unlink($small_img_path);
        }
        if(file_exists($main_img_path) && $main_img_path != '') 
        {
            @unlink($main_img_path);
        }
    }

    static function upload_image($image,$compress_image_path,$original_image_path){

        $originalName  = time() . '.' . $image->getClientOriginalName();
        $originalImageNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        
        if(!file_exists(public_path($original_image_path))) 
        {
            mkdir(public_path($original_image_path), 0755, true);
        }

        if(!file_exists(public_path($compress_image_path))) 
        {
            mkdir(public_path($compress_image_path), 0755, true);
        }
        $allowedFormats = ['jpg', 'jpeg', 'png'];

        if(in_array($image->getClientOriginalExtension(), $allowedFormats))
        {
            $image->move($original_image_path, $originalName);
            $imagePath = $original_image_path . '/' . $originalName;

            if(file_exists($imagePath)){
                
               
                $image  = Image::make($imagePath);
        
                if($image->filesize() <= 50000)
                {
                    $compress = 100;
                }
                elseif($image->filesize() <= 500000 && $image->filesize() > 50000)
                {
                    $compress = 80;
                }else
                {
                    $compress = 75;
                }

                $originalWidth  = $image->width();
                $originalHeight = $image->height();
                $minFileSize = 1 * 1024 * 1024; 

                if ($image->filesize() > $minFileSize) {
                    $targetWidth = $originalWidth;
                    $targetHeight = $originalHeight;

                    $maxFileSize = 2 * 1024;

                    while ($image->filesize() > $maxFileSize && $targetWidth > 0 && $targetHeight > 0) {
                        $targetWidth -= round($originalWidth * 0.1);
                        $targetHeight -= round($originalHeight * 0.1);

                        if ($targetWidth > 0 && $targetHeight > 0) {
                            $image->resize($targetWidth, $targetHeight, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } else {
                            break;
                        }
                    }
                }

                $webpPath = $compress_image_path . '/' . $originalImageNameWithoutExtension . '.webp';
                $image->save($webpPath, $compress);
               
                $compressedImageSize = $image->filesize();
                if($compressedImageSize <= 5 * 1024) 
                {   
                    $small_img_path = $compress_image_path . '/' . $originalImageNameWithoutExtension . '.webp';
                    if(file_exists($small_img_path)) 
                    {
                        unlink($small_img_path);
                    }
                    if(file_exists($imagePath)) 
                    {
                        unlink($imagePath);
                    }
                    
                    return [
                        'type' => 'IMAGE_COMPRESS_ISSUE',
                    ];
                }else{
                    
                    return [
                        'type' => 'SUCCESS',
                        'data' => ['vImage' => $originalName,'vWebpImage' => $originalImageNameWithoutExtension.'.webp'],
                    ];
                }
            }else{
                return [
                    'type'  => 'IMAGE_UPLOADED_ISSUE',
                ];
            }

        }else{
            return [
                'type' => 'IMAGE_UNSUPPORTED_ISSUE',
                'success' => 'Data updated successfully.',
                'error' => 'Unsupported image format. Please upload a JPG, JPEG, or PNG image.',
            ];
        }
    }

    static function get_pagination_count()
    {
        $criteria                   = array();
        $criteria['vController']    = class_basename(Route::current()->controller);
        $criteria['eStatus']        = "Active";
        $data     = PaginationModel::get_by_id($criteria);
        return $data;
    }

}

?>