@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
@section('title', 'Profile - '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
             
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    @if(isset($vUniqueCode))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('profile.edit',$vUniqueCode)}}"
                        ></i>Basic Information</a
                      >
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link active  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.organization_profile',$vUniqueCode)}}"><i class='bx bx-user' ></i> Other Information</a
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
                      <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.participant_listing',$vUniqueCode)}}"><i class='bx bx-user-circle' ></i> Participant</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.survey_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> Survey</a>
                    </li>
                    
                    @endif
                </ul>
            <form action="{{url('admin/profile/organization_profile_store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
               @csrf
             <div class="card mb-4">
               <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($vUniqueCode)){{$vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Organization Name</label>
                        <input type="text" name="vOrganizationName" id="vOrganizationName" class="form-control"
                           placeholder="Enter Organization Name"
                           value="@if(isset($organizations)){{$organizations->vOrganizationName}}@endif">
                        <div id="vOrganizationName_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Organization Name
                        </div>
                        <div id="email_unique_organization_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Different Organization Name, This Name is already in use.
                        </div>
                        <div id="email_unique_organization_success" class="error mt-1" style="color:green;display: none;">
                          <i class='bx bxs-check-circle'></i> This Organization Name Is availible.
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Tag Line</label>
                        <input type="text" name="vTagLine" id="vTagLine" class="form-control"
                           placeholder="Enter Tag Line"
                           value="@if(isset($organizations)){{$organizations->vTagLine}}@endif">
                        <div id="vTagLine_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Tag Line
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Contact Email</label>
                        <div class="input-group input-group-merge">
                           <input class="form-control"
                              type="email" name="vContactEmail" id="vContactEmail" class="form-control"
                              placeholder="Enter Email" value="@if(isset($organizations)){{$organizations->vContactEmail}}@endif"/>
                        </div>
                        <div id="email_error" class="error mt-1" style="color:red;display: none;">Please
                           Enter Email
                        </div>
                        <div id="email_valid_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Valid Email
                        </div>
                        <div id="email_unique_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Different Email, this email is already in use.
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Contact Phone</label>
                        <input type="text" name="vContactPhone" id="vContactPhone" class="form-control"
                           placeholder="Enter Phone" value="@if(isset($organizations)){{$organizations->vContactPhone}}@endif">
                        <div id="vContactPhone_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Phone
                        </div>
                        <div id="vContactPhone_valid_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter 10 Digit Mobile Number
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Location</label>
                        <input type="text" name="vLocation" id="vLocation" class="form-control"
                           placeholder="Enter Location"
                           value="@if(isset($organizations)){{$organizations->vLocation}}@endif">
                        <div id="vLocation_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Location
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>City</label>
                        <input type="text" name="vCity" id="vCity" class="form-control"
                           placeholder="Enter City"
                           value="@if(isset($organizations)){{$organizations->vCity}}@endif">
                        <div id="vCity_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter City
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Zip Code</label>
                        <input type="text" name="vZipCode" id="vZipCode" class="form-control"
                           placeholder="Enter Zip Code"
                           value="@if(isset($organizations)){{$organizations->vZipCode}}@endif">
                        <div id="vZipCode_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Zip Code
                        </div>
                     </div>
                    
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Organization Size</label>
                        <input type="text" name="vOrganizationSize" id="vOrganizationSize" class="form-control"
                           placeholder="Enter Organization Size"
                           value="@if(isset($organizations)){{$organizations->vOrganizationSize}}@endif">
                        <div id="vOrganizationSize_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Organization Size
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                           <label>Payment Type</label>
                           <select disabled name="ePaymentType" id="ePaymentType" class="form-select">
                              <option value="">Select Payment Type</option>
                              <option value="UpFront" @if(isset($organizations)) @if($organizations->ePaymentType == 'UpFront')
                              selected @endif @endif>UpFront</option>
                              <option value="Invoice" @if(isset($organizations)) @if($organizations->ePaymentType ==
                              'Invoice') selected @endif @endif>Invoice</option>
                              <option value="Other" @if(isset($organizations)) @if($organizations->ePaymentType ==
                              'Other') selected @endif @endif>Other</option>
                           </select>
                           <div id="ePaymentType_error" class="error mt-1" style="color:red;display: none;">
                              Please Select Payment Type
                            </div>
                      </div>

                      <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Total Participant</label>
                        <input type="text" readonly name="vTotalParticipant" id="vTotalParticipant" class="form-control"
                           placeholder="Enter Total Participant"
                           value="@if(isset($totalparticipent)){{$totalparticipent}}@endif">
                        <div id="vTotalParticipant_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Total Participant
                        </div>
                     </div>                       
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/dashboard')}}" class="btn-info btn">Back</a>
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

 var selectedValue = $('#eLicense').val();
   if (selectedValue == 'Yes') {
       $('.licencefields').show(); 
   } else {
      $('.licencefields').hide(); 
   }

   $(document).ready(function() {
       $('#eLicense').change(function() {
           var selectedValue = $(this).val();
           if (selectedValue == 'Yes') {
               $('.licencefields').show(); 
           } else {
               $('.licencefields').hide(); 
           }
       });
   });

 $('#vContactEmail').keyup(function() {
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
               if(result[0] != undefined){
                 $("#email_unique_error").show();
                 error = true;
               }else{

                 $("#email_unique_error").hide();
                  error = false;
               }
                 
            }
      });
 });

  $('#vOrganizationName').keyup(function() {
    var vOrganizationName = $('#vOrganizationName').val();
    $.ajax({
        url:"{{route('admin.organization.check_unique_organization')}}",
        type: "POST",
        data: {
            vOrganizationName: vOrganizationName,
            _token: '{{csrf_token()}}'
        },

        dataType : 'json',
        success: function(result){

            var OrgnameAlreadyHave = {!! isset($organizations) ? json_encode($organizations->vOrganizationName) : 'null' !!};
            if (result === null || result.length === 0) {
               error = false;
               $("#email_unique_organization_success").show();
               $("#email_unique_organization_error").hide();
            }else{
               error = true;
               if(OrgnameAlreadyHave === result[0].vOrganizationName)
               {  
                  $("#email_unique_organization_error").hide();
               }else{
                  $("#email_unique_organization_error").show();
               }
               $("#email_unique_organization_success").hide();
            }
        }
    });
 });

</script>
<script type="text/javascript">
   $(document).on('keyup', '#vContactPhone', function() {
       vContactPhone = $(this).val();
       if (vContactPhone.length > 10) {
           $('#vContactPhone').val(vContactPhone.substring(0, 10));
       }
   
   });
   $(document).on('keypress', '#vContactPhone', function(e) {
       var charCode = (e.which) ? e.which : event.keyCode
       if (String.fromCharCode(charCode).match(/[^0-9]/g))
           return false;
   });
</script>
<script type="text/javascript">
   $(document).on('click', '.submit', function() {
       var vUniqueCode        = $("#vUniqueCode").val();
       var vOrganizationName  = $("#vOrganizationName").val(); 
       var vTagLine           = $("#vTagLine").val();   
       var vContactEmail      = $("#vContactEmail").val();
       var vContactPhone      = $("#vContactPhone").val();
       var Emailregex         = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
       var Passwordregex      = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%&!]).{8,}$/; 
       var error              = false;


       if($('#email_unique_organization_error').css('display') == 'block')
       {
           $("#email_unique_organization_error").show();
            error = true;
       }else{

           $("#email_unique_organization_error").hide();
           error = false;
       }

       if (vOrganizationName.length == 0) {
           $("#vOrganizationName_error").show();
           error = true;
       } else {
           $("#vOrganizationName_error").hide();
       }

    if (error == true) {
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