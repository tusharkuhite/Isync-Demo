@extends('layouts.admin.index')
@php
$userUniqueCode = session('vUniqueCode');
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item mt-2 me-3">
                        <spna class="col-sm-6 ">
                            <h5>{{ isset($admin) ? 'Edit' : 'Add' }} Admin</h5>
                        </spna>
                    </li>
                  </ul>
             <form action="{{route('admin.admin.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
            <div class="card mb-4">
                
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <input type="file" id="vImage" class="account-file-input media_image only_image" hidden=""  name="vImage" accept="image/png, image/jpeg">
                        <img style="width: 100px; border-radius: 10px;margin-top: 7px; display:none;" class="vImage_preview_img" id="vImage_preview"
                                src="#" alt="your image" />

                       @if (!empty($admin->vWebpImage) && file_exists(public_path("uploads/user/user_small/" . $admin->vWebpImage)))                       
                        <img style="width: 100px; border-radius: 10px;margin-top: 7px;" alt="user-avatar" class=" rounded " id="image_display"
                                value="@if(old('vWebpImage') == 'vWebpImage') @endif"
                                src="{{asset('uploads/user/user_small/'.$admin->vWebpImage)}}">
                       @elseif(isset($admin))
                          
                            <!-- default image -->
                    
                            <div id="image_none">
                                <img  style="display: block;" height="100" width="100" class="d-block rounded"
                                    src="{{ asset('admin/assets/img/avatars/male.jpg') }}" alt="No photo">
                            </div>
                
                            <!-- selected image -->
                            <img style="width: 100px;display:none;border-radius: 10px;margin-top: 7px;" class="image_Preview"
                                id="vMiddleImage_preview" src="#" alt="your image" />

                         @endif
                         
                         @if(!(isset($admin)))
                         <!-- default image -->
                         <div id="image_none">
                             <img style="width: 100px; display: block;"
                                 src="{{ asset('admin/assets/img/avatars/male.jpg') }}" alt="No photo">
                         </div>
                         <!-- selected image -->
                         <img style="width: 100px;display:none;" class="image_Preview"
                             id="vMiddleImage_preview" src="#" alt="your image" />
                         @endif
                        <div class="button-wrapper">
                          <label for="vImage" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload Image</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                          </label>
                        </div>
                      </div>
                        <div id="vImage_error" class="error mt-1" style="color:red;display: none;">
                             Please Select Image
                        </div>
                        <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">
                                Allowed Maximum size of 5MB
                        </div>
                        <div id="vImage_error_min" class="error mt-1" style="color:red;display: none;">
                            Allowed Minimum size of 10KB
                        </div>
                        <div id="vImage_type_error" class="error mt-1" style="color:red;display: none;">
                            Plese Select JPG,JPEG or PNG Image.
                        </div>
                    </div>

               <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($admin)){{$admin->vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>First name</label>
                        <input type="text" name="vFirstName" id="vFirstName" class="form-control"
                           placeholder="Enter First Name"
                           value="@if(isset($admin)){{$admin->vFirstName}}@endif">
                        <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter First name
                        </div>
                     </div>
                    
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="vLastName" id="vLastName" class="form-control"
                           placeholder="Enter Last Name"
                           value="@if(isset($admin)){{$admin->vLastName}}@endif">
                        <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Last name
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Email</label>
                        <div class="input-group input-group-merge">
                           <input class="form-control"
                              type="email" name="vEmail" id="vEmail" class="form-control" 
                              placeholder="Enter Email" @if(isset($admin))@if($userUniqueCode == $admin->vUniqueCode) readonly @endif @endif value="@if(isset($admin)){{$admin->vEmail}}@endif"/>
                        </div>
                        <div id="email_error" class="error mt-1" style="color:red;display: none;">Please
                           Enter Email
                        </div>
                        <div id="email_valid_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Valid Email
                        </div>
                        <div id="email_unique_error" class="error mt-1" style="color:red;display: none;">
                           Please enter a different email; this email is already in use.
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Phone</label>
                        <input type="text" name="vPhone" id="vPhone" class="form-control" maxlength="10"
                           placeholder="Enter Phone" value="@if(isset($admin)){{$admin->vPhone}}@endif">
                        <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Phone
                        </div>
                        <div id="vPhone_valid_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter 10 Digit Mobile Number
                        </div>
                     </div>
                     
                     {{-- <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Account Verified</label>
                        <select name="eAccountVerified" id="eAccountVerified" class="form-select">
                           <option value="Active" @if(isset($admin)) @if($admin->eAccountVerified == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($admin)) @if($admin->eAccountVerified ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eAccountVerified_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Account Verified
                        </div>
                     </div> --}}

                    @if(!isset($admin))
                    <div class="form-group col-lg-6 col-md-6 last">
                        <div class="form-password-toggle">
                            <label class="" for="vPassword">Password</label>
                            <div class="input-group input-group-merge">
                              <input type="password" class="form-control" id="vPassword"
                                placeholder="Enter Password"
                                aria-describedby="basic-default-password"
                              />
                              <span class="input-group-text cursor-pointer" id="basic-default-password"
                                ><i class="bx bx-hide"></i
                              ></span>
                            </div>
                        </div>
                        <div  class="error mt-1"  style="color:red;display: none;" id="vPassword_error">Please
                           Enter Password
                        </div>
                        <div class="error mt-1" id="password_valid_error" style="color:red;display: none;">Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)</div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 last">
                        <div class="form-password-toggle">
                            <label class="" for="vPassword2">Confirm Password</label>
                            <div class="input-group input-group-merge">
                              <input type="password" class="form-control" id="vPassword2" name="vPassword2"
                                placeholder="Enter Confirm Password"
                                aria-describedby="basic-default-password"
                              />
                              <span class="input-group-text cursor-pointer" id="basic-default-password"
                                ><i class="bx bx-hide"></i
                              ></span>
                            </div>
                        </div>
                        <div id="vPassword2_error" class="error mt-1" style="color:red; display: none;">
                           Please Enter Confirm Password
                        </div>
                        <div class="error mt-1" id="vPassword2_same_error"
                           style="color:red; display: none;">Password should match</div>
                    </div>
                    @endif

                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Image Alt</label>
                        <input type="text" name="vImageAlt" id="vImageAlt" class="form-control"
                           placeholder="Enter Image Alt"
                           value="@if(isset($admin)){{$admin->vImageAlt}}@endif">
                        <div id="vImageAlt_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Image Alt
                        </div>
                    </div>
                    
                    @if(!isset($admin))
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="Active" @if(isset($admin)) @if($admin->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($admin)) @if($admin->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>
                    @endif
                    @if(isset($admin))
                    @if($userUniqueCode != $admin->vUniqueCode)
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="Active" @if(isset($admin)) @if($admin->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($admin)) @if($admin->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>
                    @else
                     <input type="hidden" name="eStatus" value="Active">
                    @endif
                    @endif
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{route('admin.admin.listing')}}" class="btn-info btn">Back</a>
               </div>
            </div>
            </form>
        
      </div>
   </div>
</div>
@endsection
@section('custom-css')
<style></style>
@endsection
@section('custom-js')
<script type="text/javascript">


        var error1 = false;
        var errors = false;
        var delayTimer;

        function unique_email(){
            var vEmail = $('#vEmail').val().trim();
            var vUniqueCode = $('#vUniqueCode').val().trim();
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                $.ajax({
                    url: "{{route('admin.admin.check_unique_email')}}",
                    type: "POST",
                    data: {
                        vEmail: vEmail,
                        vUniqueCode:vUniqueCode,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if(result) {
                            $("#email_unique_error").show();
                            error1 = true;
                         return  
                        
                        } else {
                            $("#email_unique_error").hide();
                            error1 = false;
                        }
                    }
                });
            }, 500);
        }
        $('#vEmail').keyup(function() {
            unique_email()
        });

$(".vImage_preview_img").hide();
$("#vImage").change(function() {
    var fileName = $("#vImage").val();


    if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/) ) {
    if(fileName) { 
         $("#vImage_error").hide();
         $("#image_display").hide();  
         $("#vImage_preview").show();
         $("#image_none").hide();

    } else {
        $("#image_display").show();
        $("#vImage_preview").hide(); 
    }
   }
});

// ---------------------- get url link in image or video start preview ------------>

vImage.onchange = evt => { 
  $( "#vImage_preview" ).removeClass("vImage_preview_img")
  $( "#image_display" ).addClass("vImage_preview_img")
  const fileUrl = window.URL.createObjectURL(event.target.files[0]);
  const imgExtensions = ['jpg', 'png','jpeg'];
  const name = event.target.files[0].name;
  const lastDot = name.lastIndexOf('.');

  const ext = name.substring(lastDot + 1);

   if (imgExtensions.includes(ext)) {
   $("#vImage_preview").show().attr("src", fileUrl);
   $("#image_display", window.parent.document).css(
        "display" , "none"
        );
  }else{
    $('#vImage_type_error').show();
  }

}
// ----------------- get link code end ----------------->
</script>
</script>
<script type="text/javascript">
    $(document).on('change', '#vImage', function() {
       var filesize = this.files[0].size
       var filetype = this.files[0].type;

       var maxfilesize = parseInt(filesize / 1024);
       if (maxfilesize > 5120) {
           $('#vImage').val('');
           $("#vImage_error_max").show();
           $("#save").removeClass("submit");
       }else if(maxfilesize < 10){
           $('#vImage').val('');
           $("#vImage_error_max").hide();
           $("#vImage_error_min").show();
           $("#save").removeClass("submit");
       } else {
           $("#save").addClass("submit");
           $("#vImage_error_max").hide();
           $("#vImage_error_min").hide();
       }
   });
   $(document).on('keyup', '#vPhone', function() {
       vPhone = $(this).val();
       if (vPhone.length > 10) {
           $('#vPhone').val(vPhone.substring(0, 10));
       }
   
   });
   $(document).on('keypress', '#vPhone', function(e) {
       var charCode = (e.which) ? e.which : event.keyCode
       if (String.fromCharCode(charCode).match(/[^0-9]/g))
           return false;
   });

   
   $(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var vFirstName  = $("#vFirstName").val();
       var vLastName   = $("#vLastName").val();         
       var vEmail      = $("#vEmail").val();
       var vPhone      = $("#vPhone").val();
       var vPassword   = $("#vPassword").val();
       var vPassword2  = $("#vPassword2").val(); 
       var vImage      = $("#vImage").val();
       var eStatus     = $("#eStatus").val();
       var Emailregex  = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
       var Passwordregex   = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%&!]).{8,}$/; 
       var error       = false;

      
       if($('#email_unique_error').css('display') == 'block')
       {
           $("#email_unique_error").show();
            error = true;
       }else{

           $("#email_unique_error").hide();
           error = false;
       }

        if($("#vImage_type_error").is(":visible"))
        {   
            $('#vImage_type_error').show();
            error = true;
        }else{
            $('#vImage_type_error').hide();
        }

       if (vFirstName.length == 0) {
           $("#vFirstName_error").show();
           error = true;
       } else {
           $("#vFirstName_error").hide();
       }
       if (vEmail.length == 0) {
           $("#email_error").show();
           error = true;
       } else {
           $("#email_error").hide();
       }
       if (vLastName.length == 0) {
           error = true;
           $("#vLastName_error").show();
       } else {
           $("#vLastName_error").hide();
       }
       if (vPhone.length == 0) {
           $("#vPhone_error").show();
           error = true;
       } else if (vPhone.length < 10) {
           $("#vPhone_error").hide();
           $('#vPhone_valid_error').show();
           error = true;
       } else {
           $("#vPhone_error").hide();
           $('#vPhone_valid_error').hide();
       }
       @if(!isset($admin))

         if(vImage.length == 0) {
            $("#vImage_error").show();
            $("#vImage_format_error").hide();
            error = true;
         } else {
            $("#vImage_error").hide();
         }
      @endif
       
       @if(isset($admin))
       @if($userUniqueCode != $admin->vUniqueCode)
       if (eStatus.length == 0) {
           error = true;
           $("#eStatus_error").show();
       } else {
           $("#eStatus_error").hide();
       }
       @endif
       @endif
      

      @if(!isset($admin))
        if (vPassword.length == 0) {
            $("#vPassword_error").show();
            error = true;
        } else {
            $("#vPassword_error").hide();
            if (!vPassword.match(Passwordregex)) {
                $("#password_valid_error").show();
                error = true;
            } else {
                $("#password_valid_error").hide();
            }
        }

        if (vPassword2.length == 0) {
            $("#vPassword2_error").show();
            $("#vPassword2_same_error").hide();
            error = true;
        } else {
            if (vPassword.length == 0) {
                $("#vPassword2_error").hide();
            }
        }

        if (vPassword.length != 0 && vPassword2.length != 0) {
            if (vPassword != vPassword2) {
                $("#vPassword2_same_error").show();
                $("#vPassword2_error").hide();
                return false;
            } else {
                $("#vPassword2_same_error").hide();
                $("#vPassword2_error").hide();
            }
        }
    @endif
    unique_email();

    if(error == true || error1 == true || errors == true ) {
         return false;
      } else {
         $('.submit').hide();
         $('.loading').show();
         
         setTimeout(function() {
            $("#frm").submit();
            return true;
         }, 1000);
      }
   
   });
   
</script>
@endsection