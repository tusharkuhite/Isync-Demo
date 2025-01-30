@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'Change Password- '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@php
$roles  =\App\Libraries\General::get_role();
@endphp
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
        <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Change Password</h5>
                </div>
          </div>
         
                 <form action="{{url('admin/admin/change_password_action')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                     @csrf
                <div class="card mb-4 ">
                    <div class="card-body">
                        <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="{{$vUniqueCode}}">
                        <div class="row g-3">
                           <div class="form-group col-lg-6 col-md-6 last">
                                <div class="form-password-toggle">
                                    <label for="vPassword">Password</label>
                                    <div class="input-group input-group-merge">
                                      <input type="password" class="form-control" id="vPassword" name="vPassword" placeholder="Enter Password" value="@if(old('vPassword')!=''){{old('vPassword')}}@elseif(isset($admin->vNormalPassword)){{$admin->vNormalPassword}}@else{{old('vNormalPassword')}}@endif"
                                        aria-describedby="basic-default-password"
                                      />
                                      <span class="input-group-text cursor-pointer" id="basic-default-password"
                                        ><i class="bx bx-hide"></i
                                      ></span>
                                    </div>
                                </div>
                                <div id="password_error" class="error mt-1" style="color:red;display: none;">Please Enter Password</div>
                                 <div class="error mt-1" id="password_length_error" style="color:red;display: none;">Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)</div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 last">
                                <div class="form-password-toggle">
                                    <label for="vPassword">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Password" value="@if(old('confirm_password')!=''){{old('confirm_password')}}@elseif(isset($admin->confirm_password)){{$admin->confirm_password}}@else{{old('confirm_password')}}@endif" aria-describedby="basic-default-password" />
                                      <span class="input-group-text cursor-pointer" id="basic-default-password"
                                        ><i class="bx bx-hide"></i
                                      ></span>
                                    </div>
                                </div>
                                <div id="confirm_password_error" class="error mt-1" style="color:red;display: none;">Please Enter Confirm Password</div>
                                 <div class="error mt-1" id="confirm_password_length_error" style="color:red;display: none;">password and Confirm password must be Same</div>
                            </div>
                        </div>
                     </div>
                     <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-right">
                        <a href="javascript:;" class="btn btn-primary submit_changepass">Submit</a>
                        <a href="{{url('admin/dashboard')}}" class="btn-info btn">Back</a>
                     </div>
                   </div>
                  </form>
               </div>
            </div>
          </div>
        </div>
@endsection
@section('custom-css')
<style></style>
@endsection
@section('custom-js')
<script type="text/javascript">
   $(document).ready(function(){
   
   $('#showPass').on('click', function(){
     var passInput=$("#vPassword");
     var conpassInput=$("#confirm_password");
     if(passInput.attr('type')==='password')
       {
         passInput.attr('type','text');
         conpassInput.attr('type','text');
     }else{
        passInput.attr('type','password');
        conpassInput.attr('type','password');
     }
   })
   })
</script>
<script type="text/javascript">
   $(document).on('click','.submit_changepass',function(){
     password            = $("#vPassword").val();
     confirm_password    = $("#confirm_password").val(); 
     var Passwordregex   = /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;  
     var error = false;
   
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
   
             if(confirm_password.length == 0){
                 $("#confirm_password_error").show();
                 $('#confirm_password_length_error').hide();
                 error = true;
             } else{
                 $("#confirm_password_error").hide();
                 if (password !==confirm_password) {
                     $('#confirm_password_length_error').show();
                     error = true;
                 }else{
                     $('#confirm_password_length_error').hide();     
                 }  
             }
   
     setTimeout(function(){
       if(error == true){
         return false;
       } else {
         $("#frm").submit();
         return true;
       }
     }, 1000);
   
   });
   
</script>
@endsection