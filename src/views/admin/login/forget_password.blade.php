@extends('layouts.admin.index')
@php
use App\Libraries\General;
$recaptchaSiteKey = $config_keys['GOOGLE_CAPTCHA_SITE_KEY']['vValue']; 
$setting_info = General::setting_info('Company');
@endphp
@section('content')
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Forgot Password -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
            <a href="javascript:;" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <div class="logo">
                  <img src="{{asset('uploads/logo/'.$setting_info['COMPANY_LOGO']['vValue'])}}"  alt="Logo" srcset="">
                </div>
              </span>
            </a>
          </div>
              <!-- /Logo -->
              <h4 class="mb-2">Forgot Password? 🔒</h4>
              <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
              <form action="{{route('admin.forgot_password.action')}}" method="POST" onsubmit="return validation();" class="mb-3" id="frm_forgetpass">
               @csrf
                <div class="mb-3">
                  <label for="vEmail_forgetpass" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="vEmail_forgetpass"
                    name="vEmail"
                    placeholder="Enter your email"
                    autofocus
                  />
                    <input type="hidden" name="vGoogleRecaptchaResponse" id="vGoogleRecaptchaResponse">
                   <div class="invalid-feedback" id="email_error_forgetpass" style="display: none;">Email address is required</div>
                   <div id="vEmail_valid_error_forgetpass" class="invalid-feedback" style="display: none;">Please Enter Valid Email</div>
                </div>
                <div class="mb-3">
                  <input type="submit" class="btn btn-primary d-grid w-100 submit_forgetpass" value="Send Reset Link">
                </div>
              </form>
              <div class="text-center">
                <a href="{{route('admin.login')}}" class="d-flex align-items-center justify-content-center" style="color:#ec8c00;">
                  <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                  Back to login
                </a>
              </div>
            </div>
          </div>
          <!-- /Forgot Password -->
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
        $(".submit_forgetpass").click();
    }
  });

  function validation(){
    var email       = $("#vEmail_forgetpass").val();
    var Emailregex  = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
    var error       = false;
    
    if (email.length == 0) {
      $("#email_error_forgetpass").show();
      $('#vEmail_valid_error_forgetpass').hide();
      error = true;
    } else {
      $('#email_error_forgetpass').hide();
      if (!Emailregex.test(email)) {
        $('#vEmail_valid_error_forgetpass').show();
        error = true;
      } else {
        $('#vEmail_valid_error_forgetpass').hide();
      }
    }
    
    if (error == true) {
      return false;
    } else {
      $("#frm_forgetpass").submit();
      return true;
    }
  }
</script>
@endsection
