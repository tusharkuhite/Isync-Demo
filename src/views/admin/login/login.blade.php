@php
  use App\Libraries\General;
  $company_info = General::setting_info('Company');
  $config_keys = General::config_key_info('config');
  //$recaptchaSiteKey = $config_keys['GOOGLE_CAPTCHA_SITE_KEY']['vValue']; 
@endphp

@extends('layouts.admin.index')
@section('custom-css')

@endsection
@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <form action="{{route('admin.login.login_action')}}" method="POST" onsubmit="return validation();" class="mb-3" id="frm_login">
      @csrf
      <div class="card">
        <div class="card-body">
          <div class="app-brand justify-content-center">
            <a href="javascript:;" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <div class="logo">
                  <img src="{{asset('uploads/logo/'.$company_info['COMPANY_LOGO']['vValue'])}}"  alt="Logo" srcset="">
                </div>
              </span>
            </a>
          </div>
          <div class="mb-3">
            <label for="vEmail" class="form-label">Email</label>
            <input type="text" id="vEmail_login"  name="vEmail" class="form-control" placeholder="Email" />
            <div class="invalid-feedback" id="email_error_login" style="display: none;">Email address is required</div>
            <div id="vEmail_valid_error_login" class="invalid-feedback" style="display: none;">Please Enter Valid Email</div>
          </div>
          <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="vPassword_login" class="form-control" name="vPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="vPassword"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                <div class="invalid-feedback" id="password_error_login" style="display: none;">Password is required</div>
              </div>
            </div>
            <!-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
              </div>
            </div> -->
            
            <div class="mb-3">
              <input type="submit" class="btn btn-primary d-grid w-100 submit_login" value="Sign In">
            </div>
            <div class="mb-0 text-center">
                      <a href="{{route('admin.login.forgot_password')}}" class="sub-text" style="color:#000;">Forgot Your Password?</a>
            </div>
            <input type="hidden" name="vGoogleRecaptchaResponse" id="vGoogleRecaptchaResponse">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('custom-js')
{{-- <script src="https://www.google.com/recaptcha/api.js?render={{$recaptchaSiteKey}}"></script> --}}
<script type="text/javascript">


  // $(document).ready(function() {
  //     grecaptcha.ready(function() {
  //           grecaptcha.execute(
  //             'recaptchaSiteKey', {
  //                     action: 'submit'
  //               }).then(function(token) {
  //               $("#vGoogleRecaptchaResponse").val(token);
  //           });
  //     });
  // });


  function validation(){
    var email       = $("#vEmail_login").val();
    var password    = $("#vPassword_login").val();
    var Emailregex  = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
    var error       = false;
    
    if (email.length == 0 && password.length == 0) {
        $("#password_error_login").show();
        $("#email_error_login").show();
            error = true;
            return false;
    }else{
            $("#email_error_login").hide();
            $("#password_error_login").hide();
    }
    
    if (password.length == 0) {
        $("#password_error_login").show();
        error = true;
        return false;
    } else {
        $("#password_error_login").hide();
    }

    if (email.length == 0) {
        $("#email_error_login").show();
        $('#vEmail_valid_error_login').hide();
        error = true;
        return false;
    } else {
        $('#email_error_login').hide();
        if (!Emailregex.test(email)) {
            $('#vEmail_valid_error_login').show();
            error = true;
            return false;
        } else {
            $('#vEmail_valid_error_login').hide();
        }
    }


    if (error == true) {
      return false;
    } else {
      $("#frm_login").submit();
      return true;
    }
  }
</script>

<script type="text/javascript">
  $(document).on('keypress', function(e) {
    if (e.which == 13) {
        $(".submit_login").click();
    }
  });
</script>
@endsection
