@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @if(isset($participants))
    @section('title', 'Participant Edit- '.$setting_info['COMPANY_NAME']['vValue'])
    @else
    @section('title', 'Participant Add- '.$setting_info['COMPANY_NAME']['vValue'])
    @endif
@endif
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
           <div class="d-flex justify-content-between flex-wrap gap-3 top-input-space">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    @if(isset($vUniqueCode))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('profile.edit',$vUniqueCode)}}"
                        ></i>Basic Information</a
                      >
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.organization_profile',$vUniqueCode)}}"><i class='bx bx-user' ></i> Other Information</a
                      >
                    </li>

                     <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.licence_edit',$vUniqueCode)}}"><i class='bx bx-file'></i> Licence Information</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.licenseusage_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> License Used</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link active  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.participant_listing',$vUniqueCode)}}"><i class='bx bx-user-circle' ></i> Participant</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.survey_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> Survey</a>
                    </li>
                    
                    @endif
                </ul>
            </div>

            <form action="{{url('admin/profile/participant_store', $vUniqueCode)}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
            <div class="card mb-4">
               <div class="card-body">
                    
                    <input type="hidden" id="iUserId" name="iUserId"
                     value="@if(isset($iUserId)){{$iUserId}}@endif">
                   
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($participants)){{$participants->vUniqueCode}}@endif">
                     @if(!isset($participants))
                        <div class="row g-3">
                            <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                <label>Participant Type</label>
                                <select class="form-select" name="participant_type" id="participant_type">
                                    <option value="" selected>Select Participant Type</option>
                                    <option value="single">Single Add</option>
                                    <option value="multiple">Multiple Add From CSV</option>
                                </select>
                                <div id="participant_type_error" class="error mt-1" style="color:red;display: none;">
                                    Please Select Participant Type
                                </div>
                            </div>
                        </div>
                    @endif
                 
                  <div class="row g-3" @if(isset($participants))@else style="display:none;margin-top:3px;" @endif id="single_add">
                   
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>First name</label>
                        <input type="text" name="vFirstName" id="vFirstName" class="form-control"
                           placeholder="Enter First Name"
                           value="@if(isset($participants)){{$participants->vFirstName}}@endif">
                        <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter First name
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="vLastName" id="vLastName" class="form-control"
                           placeholder="Enter Last Name"
                           value="@if(isset($participants)){{$participants->vLastName}}@endif">
                        <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Last name
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Email</label>
                        <div class="input-group input-group-merge">
                           <input class="form-control"
                              type="email" name="vEmail" id="vEmail" class="form-control"
                              placeholder="Enter Email" value="@if(isset($participants)){{$participants->vEmail}}@endif"/>
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
                        <input type="text" name="vPhone" id="vPhone" class="form-control"
                           placeholder="Enter Phone" value="@if(isset($participants)){{$participants->vPhone}}@endif">
                        <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Phone
                        </div>
                        <div id="vPhone_valid_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter 10 Digit Phone Number
                        </div>
                     </div>

                    @if(!isset($participants))
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
                        <div  class="error mt-1"  style="color:red;display: none;" id="vPassword_error">Please Enter Password
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

                    <div class="form-group col-xl-3 col-lg-12 col-md-3">
                            <label>Image </label>
                            <input class="form-control media_image only_image" accept="image/jpg, image/jpeg, image/png" type="file" id="vImage"
                                name="vImage">

                            <img style="width: 100px; border-radius: 10px;margin-top: 7px; display:none;" class="vImage_preview_img" id="vImage_preview"
                                src="#" alt="your image" />

                            @if (!empty($participants->vWebpImage) && file_exists(public_path() . "/uploads/participant/participant_small/" . $participants->vWebpImage))
                                <img style="width: 100px; border-radius: 10px;margin-top: 7px;" alt="user-avatar" class=" rounded " id="image_display"
                                value="@if(old('vWebpImage') == 'vWebpImage') @endif"
                                src="{{asset('/uploads/participant/participant_small/'.$participants->vWebpImage)}}">

                            @elseif(isset($participants))
                            <!-- default image -->

                            <div id="image_none">

                                <img alt="no-image"style="display: block;" height="100" width="100" class="d-block rounded" src="{{ asset('admin/assets/img/avatars/male.jpg') }}">
                            </div>

                            <!-- selected image -->
                            <img style="width: 100px;display:none;border-radius: 10px;margin-top: 7px;" class="image_Preview"
                                id="vMiddleImage_preview" src="#" alt="your image" />
                            @endif


                            @if(!(isset($participants)))
                            <!-- default image -->
                            <div id="image_none">
                                <img alt="no-image"style="display: block;" height="100" width="100" class="d-block rounded" src="{{ asset('admin/assets/img/avatars/male.jpg') }}">
                            </div>
                            <!-- selected image -->
                            <img style="width: 100px;display:none;" class="image_Preview"
                                id="vMiddleImage_preview" src="#" alt="your image" />
                            @endif
                            <div id="vImage_error" class="error mt-1" style="color:red;display: none;">
                                Please Select Banner
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

                        <div class="form-group col-xl-3 col-lg-12 col-md-3">
                            <label>Image Alt</label>
                            <input type="text" name="vImageAlt" id="vImageAlt" class="form-control"
                               placeholder="Enter Image Alt"
                               value="@if(isset($participants)){{$participants->vImageAlt}}@endif">
                            <div id="vImageAlt_error" class="error mt-1" style="color:red;display: none;">
                               Please Enter Image Alt
                            </div>
                        </div>
                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Status</label>
                            <select name="eStatus" id="eStatus" class="form-select">
                               <option value="Active" @if(isset($participants)) @if($participants->eStatus == 'Active')
                               selected @endif @endif>Active</option>
                               <option value="Inactive" @if(isset($participants)) @if($participants->eStatus ==
                               'Inactive') selected @endif @endif>Inactive</option>
                            </select>
                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Status
                            </div>
                        </div>
                  </div>
                  <div class="row g-3" style="display:none;margin-top:3px;" id="multiple_add">
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                       <label>Select File</label>
                       <input type="file" name="participant_file" id="participant_file" class="form-control">
                       <div id="participant_file_error" class="error mt-1" style="color:red;display: none;">
                          Please Select File
                       </div>
                       <div id="participant_file_type_error" class="error mt-1" style="color:red;display: none;">
                        Please Select CSV File
                       </div>
                        <div class="mt-2">
                         <a style="color:#ec8c00;" href="{{ asset('admin/assets/file/participant_demo.csv') }}" download="participant_demo.csv">Download CSV Example <i class='bx bxs-download'></i></a>
                        </div>
                    </div>
                    
                 </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit_participant" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/profile/participant_listing', $vUniqueCode)}}" class="btn-info btn">Back</a>
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


$(document).ready(function() {
    $('#participant_type').change(function() {
        var selectedType = $(this).val();

        $('#single_add, #multiple_add').hide();

        if (selectedType === 'single') {
            $('#single_add').show();
        } else if (selectedType === 'multiple') {
            $('#multiple_add').show();
        }
    });
});


$('#vEmail').keyup(function() {
    var vEmail = $('#vEmail').val();

    $.ajax({
        url:"{{route('admin.admin.check_unique_email')}}",
        type: "POST",
        data: {
            vEmail: vEmail,
            _token: '{{csrf_token()}}'
        },

        dataType : 'json',
        success: function(result){
           
            var OrgemailAlreadyHave = {!! isset($participants) ? json_encode($participants->vEmail) : 'null' !!};
            if(result[0] != undefined)
            { 
                if(OrgemailAlreadyHave === result[0].vEmail)
                { 
                   $("#email_unique_error").hide();
                   error = false;
                }else{
                   $("#email_error").hide();
                   $('#email_valid_error').hide();
                   $("#email_unique_error").show();
                   error = true;
                }
            }else{
                $("#email_unique_error").hide();
                error = false;
            }
        }
    });
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
  }else{
    $('#vImage_type_error').show();
  }

}
// ----------------- get link code end ----------------->
</script>
<script type="text/javascript">
    $(document).on('change', '#vImage', function() {
       var filesize = this.files[0].size
       var filetype = this.files[0].type;

       var maxfilesize = parseInt(filesize / 1024);
       if (maxfilesize > 5120) {
           $('#vImage').val('');
           $("#vImage_error_max").show();
           $("#save").removeClass("submit_participant");
       }else if(maxfilesize < 10){
           $('#vImage').val('');
           $("#vImage_error_max").hide();
           $("#vImage_error_min").show();
           $("#save").removeClass("submit_participant");
       } else {
           $("#save").addClass("submit_participant");
           $("#vImage_error_max").hide();
           $("#vImage_error_min").hide();
       }
    });
    $(document).on('change', '#vImage', function() {
       var filesize = this.files[0].size
       var maxfilesize = parseInt(filesize / 1024);
       if (maxfilesize > 5120) {
           $('#vImage').val('');
           $("#vImage_error_max").show();
           $("#save").removeClass("submit_participant");
           return false;
       } else {
           $("#save").addClass("submit_participant");
           $("#vImage_error_max").hide();
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

   $(document).on('click', '.submit_participant', function() 
   {
    

    var participant_type = $("#participant_type").val();

    var vUniqueCode = $("#vUniqueCode").val();
    var vFirstName  = $("#vFirstName").val();
    var vLastName   = $("#vLastName").val();
    var vEmail      = $("#vEmail").val();
    var vPhone      = $("#vPhone").val();
    var vPassword   = $("#vPassword").val();
    var vPassword2  = $("#vPassword2").val();
    var vImage      = $("#vImage").val();
    var eStatus     = $("#eStatus").val();
    var participant_file = $('#participant_file').val();
    var Emailregex      = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
    var Passwordregex   = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%&!]).{8,}$/;
    var error           = false;

    @if(isset($participants))
      var participant_type   = "single";
    @endif

    if(participant_type.length != 0)
    {   
        $("#participant_type_error").hide();

        if(participant_type == "single")
        {
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

            if (vPhone.length == 0) {
                $("#vPhone_error").show();
                error = true;
            } else {
                $("#vPhone_error").hide();
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

            if (eStatus.length == 0) {
                error = true;
                $("#eStatus_error").show();
            } else {
                $("#eStatus_error").hide();
            }
            if (vEmail.length == 0) {
                $("#email_error").show();
                $('#email_valid_error').hide();
                $("#email_unique_error").hide();
                error = true;
            } else {
                $('#email_error').hide();
                
                if (!Emailregex.test(vEmail)) {
                    $('#email_valid_error').show();
                    error = true;
                } else {
                    $('#email_valid_error').hide();
                }
            }
        }
        else if(participant_type == "multiple")
        {    


            if(participant_file.length == 0)
            {
                $('#participant_file_error').show();
                error = true;
            }
            else
            {
                $('#participant_file_error').hide();

                var file = document.querySelector("#participant_file");
                if(file.files[0].type == 'text/csv')
                {
                    $('#participant_file_type_error').hide();
                }
                else
                {
                    error = true;
                    $('#participant_file_type_error').show();
                }

            }
        }

       
        @if(!isset($participants))
       
            if (vPassword.length == 0) {
                //$("#vPassword_error").show();
                //error = true;
            } else {
                $("#vPassword_error").hide();
                if (!vPassword.match(Passwordregex)) {
                    $("#password_valid_error").show();
                    error = true;
                } else {
                    $("#password_valid_error").hide();
                }
            }

            if (vPassword.length != 0 && vPassword2.length == 0) {
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


    }else{

        $("#participant_type_error").show();
        error = true;
    }
        
    
  
    if (error == true) {
        return false;
    } else {
        $('.submit_participant').hide();
        $('.loading').show();

        setTimeout(function() {
            $("#frm").submit();
            return true;
        }, 1000);
    }

   });

</script>
@endsection
