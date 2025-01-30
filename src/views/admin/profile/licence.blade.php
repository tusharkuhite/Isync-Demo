@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
@section('title', 'Licence - '.$setting_info['COMPANY_NAME']['vValue'])
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
                      <a class="nav-link  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.organization_profile',$vUniqueCode)}}"><i class='bx bx-user' ></i> Other Information</a
                      >
                    </li>

                     <li class="nav-item">
                      <a class="nav-link active @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.licence_edit',$vUniqueCode)}}"><i class='bx bx-file'></i> Licence Information</a
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
            <form action="{{url('admin/organization/licence_store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
             <div class="card mb-4">
               <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($vUniqueCode)){{$vUniqueCode}}@endif">
                  <div class="row g-3">
                     

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>License</label>
                        <select name="eLicense" disabled id="eLicense" class="form-select">
                           <option value="Yes" @if(isset($organizations)) @if($organizations->eLicense == 'Yes')
                           selected @endif @endif>Yes</option>
                           <option value="No" @if(isset($organizations)) @if($organizations->eLicense ==
                           'No') selected @endif @endif>No</option>
                        </select>
                        <div id="eLicense_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Zip Code
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6 licencefields" style="display:none;">
                        <label>License Period</label>
                        <select name="eLicensePeriod" disabled id="eLicensePeriod" class="form-select">
                           <option value="Days" @if(isset($organizations)) @if($organizations->eLicensePeriod == 'Days')
                           selected @endif @endif>Days</option>
                           <option value="Week" @if(isset($organizations)) @if($organizations->eLicensePeriod ==
                           'Week') selected @endif @endif>Week</option>
                           <option value="Month" @if(isset($organizations)) @if($organizations->eLicensePeriod ==
                           'Month') selected @endif @endif>Month</option>
                           <option value="Year" @if(isset($organizations)) @if($organizations->eLicensePeriod ==
                           'Year') selected @endif @endif>Year</option>
                        </select>
                        <div id="eLicensePeriod_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Zip Code
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6 licencefields" style="display:none;">
                         <label>Duaration</label>
                         <input type="text"readonly name="vDuration" id="vDuration" class="form-control" 
                                placeholder="Enter Duration Days/Week/Month/Year (ex.10 Days, 2 Week, 1 Month, 5 Year)" 
                                value="@if(isset($organizations)){{$organizations->vDuration}}@endif" 
                                oninput="this.value = this.value.replace(/\D/g, '').substr(0, 3); 
                                if(parseInt(this.value) > 365) { this.value = '365'; }"> 
                        <div id="vDuration_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Duration Days/Week/Month/Year (ex.10 Days, 2 Week, 1 Month, 5 Year)
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6 licencefields" style="display:none;">
                        <label>License Expiry Date</label>
                        <input type="date" readonly name="dLicenseExpiryDate" id="dLicenseExpiryDate" min="{{ date('Y-m-d') }}" class="form-control"
                           placeholder="Select License Expiry Date"
                           value="@if(isset($organizations)){{$organizations->dLicenseExpiryDate}}@endif">
                           <div id="dLicenseExpiryDate_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Expiry Date using Date Select or using Duaration
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6 licencefields" style="display:none;">
                        <label>Number of License(credit)</label>
                        <input type="text" readonly  name="vValue" id="vValue"  class="form-control"
                           placeholder="Enter Number of License"
                           value="@if(isset($organizations)){{$organizations->vValue}}@endif">
                           <div id="vValue_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Number of License
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6 licencefields" style="display:none;">
                        <label>Number of Remaining License(credit)</label>
                        <input type="text" readonly  name="" id="remaining_license"  class="form-control"
                           value="@if(isset($organizations)){{$organizations->remaining_license}}@endif">
                     </div>
                                        
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit disabled" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                 <a href="{{url('admin/dashboard')}}" class="btn-info btn ">Back</a>
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

   document.addEventListener('DOMContentLoaded', function() {
        const periodSelect = document.getElementById('eLicensePeriod');
        const valueInput = document.getElementById('vDuration');
        const expiryDateInput = document.getElementById('dLicenseExpiryDate');

        function calculateExpiryDate() {
            const selectedPeriod = periodSelect.value;
            const value = valueInput.value;

            let expiryDate = new Date();

            if (selectedPeriod === 'Days') {
                expiryDate.setDate(expiryDate.getDate() + parseInt(value));
            } else if (selectedPeriod === 'Week') {
                expiryDate.setDate(expiryDate.getDate() + (parseInt(value) * 7));
            } else if (selectedPeriod === 'Month') {
                expiryDate.setMonth(expiryDate.getMonth() + parseInt(value));
            } else if (selectedPeriod === 'Year') {
                expiryDate.setFullYear(expiryDate.getFullYear() + parseInt(value));
            }

            const formattedExpiryDate = expiryDate.toISOString().split('T')[0];
            expiryDateInput.value = formattedExpiryDate;
        }

        periodSelect.addEventListener('change', calculateExpiryDate);
        valueInput.addEventListener('input', calculateExpiryDate);
  });


   document.addEventListener('DOMContentLoaded', function() {
        const periodSelect = document.getElementById('eLicensePeriod');
        const valueInput = document.getElementById('vDuration');
        const expiryDateInput = document.getElementById('dLicenseExpiryDate');

        function calculateExpiryDate() {
            const selectedPeriod = periodSelect.value;
            const value = valueInput.value;

            let expiryDate = new Date();

            if (selectedPeriod === 'Days') {
                expiryDate.setDate(expiryDate.getDate() + parseInt(value));
            } else if (selectedPeriod === 'Week') {
                expiryDate.setDate(expiryDate.getDate() + (parseInt(value) * 7));
            } else if (selectedPeriod === 'Month') {
                expiryDate.setMonth(expiryDate.getMonth() + parseInt(value));
            } else if (selectedPeriod === 'Year') {
                expiryDate.setFullYear(expiryDate.getFullYear() + parseInt(value));
            }

            const formattedExpiryDate = expiryDate.toISOString().split('T')[0];
            expiryDateInput.value = formattedExpiryDate;
        }

        periodSelect.addEventListener('change', calculateExpiryDate);
        valueInput.addEventListener('input', calculateExpiryDate);
        valueInput.addEventListener('keyup', calculateExpiryDate);
   });




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

</script>

<script type="text/javascript">
   $(document).on('click', '.submit', function() {
       var vUniqueCode        = $("#vUniqueCode").val();
       var eLicense           = $("#eLicense").val();
       var dLicenseExpiryDate = $("#dLicenseExpiryDate").val();
       var error              = false;

      

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