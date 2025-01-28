@extends('layouts.admin.index')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($menues) ? 'Edit' : 'Add' }} Menu</h5>
            </div>
         </div>
      
         <form action="{{route('admin.menu.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
            <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($menues)){{$menues->vUniqueCode}}@endif">
                  <div class="row g-3">

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                           <label>Role</label>
                           <select id="iRoleId" name="iRoleId" class="form-select">
                               <option value="">Select Role</option>
                               @foreach($roles as $value)
                               <option value="{{$value->iRoleId}}" @if(isset($menues)) @if($menues->iRoleId == $value->iRoleId) selected @endif @endif>{{$value->vRole}}</option>
                               @endforeach
                           </select>
                           <div id="iRoleId_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Role</div>
                     </div>
                     
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Menu</label>
                        <input type="text" name="vMenu" id="vMenu" class="form-control"
                           placeholder="Enter Menu"
                           value="@if(isset($menues)){{$menues->vMenu}}@endif">
                        <div id="vMenu_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Menu
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Icon Code</label>
                        <input type="text" name="vCode" id="vCode" class="form-control"
                           placeholder="Ex. bx bx-user"
                           value="@if(isset($menues)){{$menues->vCode}}@endif">
                        <div id="vCode_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Make
                        </div>
                     </div>
                     

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Feature</label>
                        <select name="eFeature" id="eFeature" class="form-select">
                           <option value="">Select Feature</option>
                           <option value="Yes" @if(isset($menues)) @if($menues->eFeature ==
                           'Yes') selected @endif @endif>Yes</option>
                           <option value="No" @if(isset($menues)) @if($menues->eFeature == 'No')
                           selected @endif @endif>No</option>
                        </select>
                        <div id="eFeature_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Feature
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                         <label>Order</label>
                         <input type="number" name="iOrder" id="iOrder" min="1" class="form-control"
                            placeholder="Enter Order"
                            value="@if(isset($menues)){{$menues->iOrder}}@endif">
                         <div id="iOrder_error" class="error mt-1" style="color:red;display: none;">
                            Please Enter Order
                         </div>
                     </div>
                 
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="">Select Status</option>
                           <option value="Active" @if(isset($menues)) @if($menues->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($menues)) @if($menues->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                           <option value="Pending" @if(isset($menues)) @if($menues->eStatus ==
                           'Pending') selected @endif @endif>Pending</option>
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
                  <a href="{{route('admin.menu.listing')}}" class="btn-info btn">Back</a>
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
   $('#iOrder').keydown(function (e) {
        if (e.shiftKey || e.ctrlKey || e.altKey) {
            e.preventDefault();
        } else {
        var key = e.keyCode;
            if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57)      || (key >= 96 && key <= 105))) {
                e.preventDefault();
            }
        }
   });

   $(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var vMenu       = $("#vMenu").val();
       var vCode       = $("#vCode").val();
       var eStatus     = $("#eStatus").val();
       var eFeature    = $("#eFeature").val();
       var iRoleId     = $("#iRoleId").val();

       var error = false;


       if (eFeature.length == 0) {
           error = true;
           $("#eFeature_error").show();
       } else {
           $("#eFeature_error").hide();
       }
       if (vCode.length == 0) {
           error = true;
           $("#vCode_error").show();
       } else {
           $("#vCode_error").hide();
       }
       if (iRoleId.length == 0) {
           error = true;
           $("#iRoleId_error").show();
       } else {
           $("#iRoleId_error").hide();
       }
   
       if (vMenu.length == 0) {
           $("#vMenu_error").show();
           error = true;
       } else {
           $("#vMenu_error").hide();
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