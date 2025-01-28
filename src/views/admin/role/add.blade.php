@extends('layouts.admin.index')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($roles) ? 'Edit' : 'Add' }} Role</h5>
            </div>
         </div>

         <form action="{{route('admin.role.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
            <div class="card mb-4">
              <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($roles)){{$roles->vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Role</label>
                        <input type="text" name="vRole" id="vRole" class="form-control"
                           placeholder="Enter Role"
                           value="@if(isset($roles)){{$roles->vRole}}@endif">
                        <div id="vRole_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Role
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Code</label>
                        <input type="text" name="vCode" id="vCode" class="form-control"
                           placeholder="Enter Code"
                           value="@if(isset($roles)){{$roles->vCode}}@endif">
                        <div id="vCode_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Code
                        </div>
                     </div>
                
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="Active" @if(isset($roles)) @if($roles->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($roles)) @if($roles->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>

                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{route('admin.role.listing')}}" class="btn-info btn">Back</a>
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
 
   $(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var vRole       = $("#vRole").val();
       var vCode       = $("#vCode").val();
       var eStatus     = $("#eStatus").val();

       var error = false;
   
       if (vRole.length == 0) {
           $("#vRole_error").show();
           error = true;
       } else {
           $("#vRole_error").hide();
       }
       if (vCode.length == 0) {
           error = true;
           $("#vCode_error").show();
       } else {
           $("#vCode_error").hide();
       }
       if (eStatus.length == 0) {
           error = true;
           $("#eStatus_error").show();
       } else {
           $("#eStatus_error").hide();
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