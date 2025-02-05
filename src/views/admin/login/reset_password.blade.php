@extends('layouts.admin.index')
@php
use App\Libraries\General;
$config_keys = General::config_key_info('config');
$recaptchaSiteKey = $config_keys['GOOGLE_CAPTCHA_SITE_KEY']['vValue']; 
$setting_info = General::setting_info('Company');
@endphp
@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <form action="{{route('admin.reset_password.action')}}" method="POST" onsubmit="return validation();" class="mb-3" id="frm_resetpass">
      @csrf
      <input type="hidden" id="code" name="code" value="{{$code}}">
      <div class="card">
        <div class="card-body">
          <div class="app-brand justify-content-center">
            <a href="javascript:;" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <div class="logo">
                  <img src="{{asset('uploads/logo/'.$setting_info['COMPANY_LOGO']['vValue'])}}"  alt="Logo" srcset="">
                </div>
              </span>
            </a>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Set New Password</label>
              </div>
              <input type="hidden" name="vGoogleRecaptchaResponse" id="vGoogleRecaptchaResponse">
              <div class="input-group input-group-merge">
                <input type="password" id="vPassword_reset" class="form-control" name="vPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="vPassword"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                <div class="invalid-feedback" id="password_error_login" style="display: none;">Password is required</div>
                <div id="password_error" class="invalid-feedback" style="color:red;display: none;">Please Enter Password</div>
                <div class="invalid-feedback" id="password_length_error" style="color:red;display: none;">Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)</div>
              </div>
          </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary d-grid w-100 submit_resetpass" value="Reset">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('custom-js')

<script src="https://www.google.com/recaptcha/api.js?render={{$recaptchaSiteKey}}"></script>
<script type="text/javascript">

  $(document).ready(function() {
      grecaptcha.ready(function() {
            grecaptcha.execute(
              '{{$recaptchaSiteKey}}', {
                      action: 'submit'
                }).then(function(token) {
                $("#vGoogleRecaptchaResponse").val(token);
            });
      });
  });


  $(document).on('keypress', function(e) {
    if (e.which == 13) {
        $(".submit_resetpass").click();
    }
  });

  
  function validation(){
    var password      = $("#vPassword_reset").val();
    var Passwordregex = /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
    var error         = false;
    
    
    if(password.length == 0){
                 $("#password_error").show();
                 $('#password_length_error').hide();
                 error = true;
    } else{
           $("#password_error").hide();
           if(!Passwordregex.test(password)) {
               $('#password_length_error').show();
               error = true;
           }else{
               $('#password_length_error').hide();
           }
    }
    
    if (error == true) {
      return false;
    } else {
      $("#frm_resetpass").submit();
      return true;
    }
  }
</script>
@endsection
