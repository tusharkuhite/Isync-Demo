<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\LoginModel;
use App\Models\admin\SystemEmailModel;
use App\Libraries\General;
use Session;
use Auth;
use Artisan;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.login');
    }

    function verifyRecaptcha($responseToken) {
        $config_keys = General::config_key_info('config');
        $recaptchaSecretKey = $config_keys['GOOGLE_CAPTCHA_SECRET_KEY']['vValue']; 
        // dd($recaptchaSecretKey);

        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    
        $data = array(
            'secret' => $recaptchaSecretKey,
            'response' => $responseToken
        );
    
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $verifyResponse = file_get_contents($verifyUrl, false, $context);
        $responseData = json_decode($verifyResponse);
        return $responseData->success;
    }

    public function login_action(Request $request)
    {
        // $recaptchaResponse  = $request->vGoogleRecaptchaResponse;
       
        // if ($this->verifyRecaptcha($recaptchaResponse)) {
          
            if($request->vEmail == null || $request->vPassword == null) 
            {
                return redirect()->route('admin.login')->withError('Please Fill Details.');
            }
            $users = User::where('vEmail', '=', $request->vEmail)->first();

            if($users != null && $users->eStatus != null && $users->eStatus == "Inactive")
            {
                return redirect()->route('admin.login')->withError('This Account Status is Inactive.');
            }
            if($users != null && $users->eStatus != null && $users->eStatus == "Pending") 
            {
                return redirect()->route('admin.login')->withError('This Account Status is Pending.');
            }
            if($users != null &&  $users->eStatus != null && $users->eDelete == "Yes") 
            {
                return redirect()->route('admin.login')->withError('This Account is Deleted From the System.');
            }

            if($users === null) 
            {
                return redirect()->route('admin.login')->withError('User not found.');
            }
            else
            {
                $vEmail                = strtolower($request->vEmail);
                $vPassword             = md5($request->vPassword);
                $criteria              = array();
                $criteria['vEmail']    = $vEmail;
                $criteria['vPassword'] = $vPassword;
                $credential            = LoginModel::login($criteria);

                if(!empty($credential))
                {
                    
                    Session::put('vEmail',$vEmail);
                    $username = $credential->vFirstName.' '.$credential->vLastName;
                    Session::put('vWebpImage',$credential->vWebpImage);
                    Session::put('username',$username);
                    Session::put('iUserId',$credential->iUserId);
                    Session::put('vUniqueCode',$credential->vUniqueCode);
                    Session::put('iRoleId',$credential->iRoleId);

                    return redirect()->route('admin.dashboard')->withToastwelcome('Signed in');
                }
                return redirect()->route('admin.login')->withError('Login details are not valid');
            }
        // } else {
            
        //     return redirect()->route('admin.login')->withError('reCAPTCHA verification failed!');
        // }
    }

    public function forgot_password()
    {
        return view('admin.login.forget_password');
    }

    public function forgot_password_action(Request $request)
    {
        // $recaptchaResponse  = $request->vGoogleRecaptchaResponse;
       
        // if ($this->verifyRecaptcha($recaptchaResponse)) {
            $vEmail   = strtolower($request->vEmail);
            $criteria = array();
            $criteria['vEmail']  = $vEmail;
            $criteria['eStatus'] = "Active";
            $criteria['eDelete'] = "No";
            $data   = LoginModel::email_exist($criteria);
            if(empty($data))
            {
                return redirect()->route('admin.login.forgot_password')->with('error',"This Email does not exist");
            }
            else
            {
                if($data->eStatus == 'Active')
                {
                    $auth_code = md5($data->vEmail);
                    $criteria = array();
                    $criteria['vEmailCode'] = 'ADMIN_FORGOT_PASSWORD';
                    $criteria['eStatus']    = 'Active';
                    $email = SystemEmailModel::get_by_id($criteria);
                    
                    if($email != null)
                    {
                        $company_setting = General::setting_info('company');
                        $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
                        $constant   = array('#vFirstName#','#vLastName#','#activation_link#','#COMPANY_EMAIL#');
                        $value      = array($data->vFirstName,$data->vLastName, route('admin.reset_password',$auth_code),$company_setting['COMPANY_EMAIL']['vValue']);
                        $message = str_replace($constant, $value, $email->tEmailMessage);
                        
                        $email_data['to']       = strtolower($request->vEmail);
                        $email_data['subject']  = $subject;
                        $email_data['msg']      = $message;
                        $email_data['from']     = $email->vFromEmail;
                        $General = new General;
                        $General->send_email($email_data);
                        
                        $data1['vAuthCode']         = $auth_code;
                        $where                      = array();
                        $where['vUniqueCode']       = $data->vUniqueCode;

                        LoginModel::UpdateData($where, $data1);
                        
                        return redirect()->route('admin.login')->with('success',"Please check your registered email for reset your password");
                    }
                    else
                    {
                        return redirect()->route('admin.login')->with('error',"Email Can't Send");
                    }
                }
                else
                {
                    return redirect()->route('admin.forgot_password')->with('error',"Your Account Under Review");
                }
            }
        // } else {   
        //         return redirect()->route('admin.login')->withError('reCAPTCHA verification failed!');
        //     }
    }

    public function reset_password($code)
    {
        $criteria              = array();
        $criteria['vAuthCode'] = $code;
        $result                = LoginModel::authentication($criteria);
        $data['code']          = $code;
        if(!empty($result))
        {
            return view('admin.login.reset_password',$data);
        }
        else
        {
            return redirect()->route('admin.login');
        }
    }

    public function reset_password_action(Request $request)
    {
        // $recaptchaResponse  = $request->vGoogleRecaptchaResponse;
       
        // if ($this->verifyRecaptcha($recaptchaResponse)) {
            $criteria = array();
            $criteria['vAuthCode'] = $request->code;
            $result = LoginModel::authentication($criteria);
            if(!empty($result))
            {
                $data                       = array();
                $data['vPassword']          = md5($request->vPassword);
                $data['vAuthCode']          = '';
                $where                      = array();
            $where['vUniqueCode']       = $result->vUniqueCode;
            $ID = LoginModel::UpdateData($where, $data);
            
            return redirect()->route('admin.login')->with('success',"Password reset successfully");
            } 
            else 
            {
                return redirect()->route('admin.login')->with('error',"Password reset failed");
            }
        // } else {
        //        return redirect()->route('admin.login')->withError('reCAPTCHA verification failed!');
        //    }
    }
    
    public function logout() 
    {
        $iUserId = Session::get('iUserId');
        $username = Session::get('username');

        Session::flush();
        Auth::logout();
        Artisan::call('cache:clear');
        return redirect()->route('admin.login')->with('success',"Logout Successfully");
    }
}
